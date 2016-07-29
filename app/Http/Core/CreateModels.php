<?php
/**
 * Created by PhpStorm.
 * User: kery
 * Date: 2016/7/11
 * Time: 13:48
 */
namespace App\Http\Core;

use Carbon\Carbon;
use DB;

class CreateModels
{
    public function run($path){
        if(empty($path)){
            $path = app_path('Models/');
        }
        $tables = \DB::table('ad_table')->where('isactive','Y')->where('ISVIEW','N')->get();

        foreach($tables as $table){
            $filename = 'X_'.strtoupper($table->TABLENAME);
            $file = $path.$filename.'.php';
            if(file_exists($file)){
                $result = @unlink ($file);
                if($result == false){
                    echo  $filename."删除失败<br>";
                }
            }

            $model_file = fopen($file, "w");
            fwrite($model_file, "<?php\r\nnamespace App\\Models;\r\n\r\nuse App\\Eloquent\\Model;\r\n\r\n");
            fwrite($model_file, "class ".$filename." extends Model\r\n{\r\n\tprotected \$table = '".strtolower($table->TABLENAME)."';\r\n\r\n");

            $columns = \DB::table('AD_COLUMN')->where('AD_TABLE_ID', $table->AD_TABLE_ID)->orderBy('ISKEY','DESC')->get();

            foreach($columns as $column){

                if($column->ISKEY == 'Y'){
                    fwrite($model_file, "\tprotected \$primaryKey = '". strtolower($column->COLUMNNAME) ."';\r\n\r\n");
                }

                if(strtoupper($column->COLUMNNAME) == 'ISACTIVE'){
                    fwrite($model_file, "\tpublic function scopeActive(\$query){\r\n\t\treturn \$query->where('ISACTIVE', 'Y');\r\n\t}\r\n\r\n");
                }
            }
            fwrite($model_file, "\r\n}");
            fclose($model_file);
            echo "创建".$file."成功！<br>";
        }
        echo "执行完成！<br>";
    }

    public function createColumn($table_id){
        $table_obj = \DB::table('ad_table')->where('ad_table_id', $table_id)->first();

        $mamager = \DB::getSchemaBuilder()->getConnection()->getDoctrineSchemaManager();
        $table = $mamager->listTableDetails($table_obj->TABLENAME);
        $columns = $table->getColumns();
        foreach($columns as $key => $column){
            $cn = \DB::table('ad_column')->where('AD_TABLE_ID', $table_id)->where('COLUMNNAME', $column->getName())->count();
            if(!$cn){
                if(strtoupper($table_obj->TABLENAME).'_ID' == strtoupper($column->getName())){
                    //数据库列名与表名+'_ID'相同，则为关键列
                    $iskey = 'Y';
                }else{
                    $iskey = 'N';
                }
                $data = [
                    'AD_CLIENT_ID'=>0,
                    'AD_ORG_ID'=>0,
                    'AD_REFERENCE_ID'=>0,
                    'AD_TABLE_ID'=>$table_obj->AD_TABLE_ID,
                    'COLUMNNAME'=>$column->getName(),
                    'CREATED'=>Carbon::now(),
                    'ENTITYTYPE'=>'D',
                    'ISKEY'=>$iskey,
                    'NAME'=>$column->getName(),
                    'UPDATED'=>Carbon::now(),
                ];
                \DB::table('ad_column')->insert($data);
            }
        }
        echo 'OK';
    }

    public function createField($tab_id){
        $tab_obj = \DB::table('ad_tab')->where('ad_tab_id', $tab_id)->first();
        $columns = \DB::table('ad_column')->where('AD_TABLE_ID', $tab_obj->AD_TABLE_ID)->get();

        foreach($columns as $column){
            $cn = \DB::table('ad_field')->where('AD_TAB_ID', $tab_id)->where('AD_COLUMN_ID', $column->AD_COLUMN_ID)->count();
            if(!$cn){
                $data = [
                    'AD_CLIENT_ID'=>0,
                    'AD_COLUMN_ID'=>$column->AD_COLUMN_ID,
                    'AD_ORG_ID'=>0,
                    'AD_REFERENCE_ID'=>0,
                    'AD_TAB_ID'=>$tab_id,
                    'CREATED'=>Carbon::now(),
                    'DISPLAYLENGTH'=>12,
                    'ENTITYTYPE'=>'D',
                    'NAME'=>$column->NAME,
                    'UPDATED'=>Carbon::now(),
                ];
                \DB::table('ad_field')->insert($data);
            }
        }
        echo 'OK';
    }

    public function showWindow($window_id){
        $window = \DB::table('ad_window')->where('ad_window_id', $window_id)->first();
        $tabs = \DB::table('ad_tab')->where('ISACTIVE', 'Y')->where('ISDISPLAYED','Y')->where('ad_window_id', $window_id)->orderBy('SEQNO')->get();
        foreach($tabs as $tab){
            $fields = \DB::table('ad_field')
                ->join('ad_column', 'ad_field.AD_COLUMN_ID', '=', 'ad_column.AD_COLUMN_ID')
                ->where('ad_tab_id', $tab->AD_TAB_ID)->where('ad_field.ISACTIVE', 'Y')->where('ad_field.ISDISPLAYED','Y')
                ->orderBy('ad_field.SEQNO')->get(['ad_field.*','ad_column.COLUMNNAME']);
            $tab->fields = $fields;

            //获取tab对应表的主键列
            $id_column = \DB::table('ad_column')->where('AD_TABLE_ID', $tab->AD_TAB_ID)->where('ISKEY','Y')->get();
            if(count($id_column) == 1){
                $tab->id_name = $id_column[0]->COLUMNNAME;
            }else{
                $tab->id_name = '';
            }

            //获取tab对应表的父表关联列
            $p_columns = \DB::table('ad_column')->where('ad_table_id', $tab->AD_TAB_ID)->where('ISPARENT','Y')->lists('COLUMNNAME');
            $tab->parent_names = $p_columns;
        }
        //return $tabs->list('COLUMNNAME');
        return view('layout.window',['window'=>$window, 'tabs'=>$tabs]);
    }

    public static function getTableDate($table_id){
        $table = \DB::table('ad_table')->where('ad_table_id', $table_id)->first();
        $p_columns = \DB::table('ad_column')->where('ad_table_id', $table_id)->where('ISPARENT','Y')->get();
        $params = request()->all();
        if($p_columns){
            $builder = \DB::table($table->TABLENAME);
            foreach($p_columns as $p){
                if(!isset($params[$p->COLUMNNAME])){
                    return json_encode([]);
                }

                $builder = $builder->where($p->COLUMNNAME, $params[$p->COLUMNNAME]);
            }
            $table_datas = $builder->get();
        }else{
            $table_datas = \DB::table($table->TABLENAME)->get();
        }

        return json_encode($table_datas);
    }

    public static function showEdit($tab_id, $record_id = 0){
        $tab = DB::table('ad_tab')->where('ad_tab_id', $tab_id)->first();
        $table = DB::table('ad_table')->where('ad_table_id', $tab->AD_TABLE_ID)->first();
        $table_datas = array();
        if($record_id > 0){
            $table_datas = DB::table($table->TABLENAME)->where($table->TABLENAME.'_ID', $record_id)->first();
        }

        $fields = \DB::table('ad_field')
            ->join('ad_column', 'ad_field.AD_COLUMN_ID', '=', 'ad_column.AD_COLUMN_ID')
            ->where('ad_tab_id', $tab_id)->where('ad_field.ISACTIVE', 'Y')->where('ad_field.ISDISPLAYED','Y')
            ->orderBy('ad_field.SEQNO')->get(['ad_field.*','ad_column.COLUMNNAME']);
        //dd($table_datas);
        $view = view('layout.window_edit', ['table_id'=>$tab->AD_TABLE_ID, 'record_id'=>$record_id,'fields'=>$fields, 'table_datas'=>$table_datas]);
        return htmlspecialchars_decode((string)$view);
    }

    public function saveEdit(){
        $table_id = request('table_id');
        $table = DB::table('ad_table')->where('ad_table_id', $table_id)->first();
        $columns = DB::table('ad_column')->where('ad_table_id', $table_id)->get();
        $record_id = request('record_id');
        $data = array();
        if($record_id > 0){
            //修改数据
            foreach($columns as $column){
                if(!empty($column->COLUMNSQL) || $column->ISUPDATEABLE == 'N'){
                    //虚拟列、不可修改列、ID列
                    continue;
                }

                if(request()->has($column->COLUMNNAME)){
                    if($column->ISMANDATORY == 'Y' && empty(request($column->COLUMNNAME))){
                        //如果保存强制性的，但form值为空，则报错
                        return $column->NAME.'不能为空！';
                    }

                    $data[$column->COLUMNNAME] = request($column->COLUMNNAME);
                }
            }

            //如果没有更新日期，创建日期为当前日期
            if($column->COLUMNNAME == 'UPDATED' && !isset($data[$column->COLUMNNAME])){
                $data[$column->COLUMNNAME] = Carbon::now();
            }
            DB::table($table->TABLENAME)->where($table->TABLENAME.'_ID', $record_id)->update($data);
        }else{
            //新增数据
            foreach($columns as $column){
                if(!empty($column->COLUMNSQL) || $column->ISUPDATEABLE == 'N'){
                    //虚拟列、不可修改列、ID列
                    continue;
                }

                if(request()->has($column->COLUMNNAME)){
                    $data[$column->COLUMNNAME] = request($column->COLUMNNAME);
                }elseif(!empty($column->DEFAULTVALUE)){
                    $data[$column->COLUMNNAME] = $column->DEFAULTVALUE;
                }

                //如果没有创建日期，创建日期为当前日期
                if(($column->COLUMNNAME == 'CREATED' || $column->COLUMNNAME == 'UPDATED') && !isset($data[$column->COLUMNNAME])){
                    $data[$column->COLUMNNAME] = Carbon::now();
                }

                if($column->ISMANDATORY == 'Y' && (!isset($data[$column->COLUMNNAME]) || empty(request($column->COLUMNNAME)))){
                    //如果保存强制性的，但新增值为空，则报错
                    return $column->NAME.'不能为空！';
                }
            }

            DB::table($table->TABLENAME)->insert($data);
        }
        return 'success';
    }
}