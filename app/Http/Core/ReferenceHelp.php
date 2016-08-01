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

class ReferenceHelp
{
    public static function htmlTag($field_id, $value){
        $field = DB::table('ad_field')->where('ad_field_id', $field_id)->first();
        $column = DB::table('ad_column')->where('ad_column_id', $field->AD_COLUMN_ID)->first();
        $column->COLUMNNAME = strtoupper($column->COLUMNNAME);
        $rs = '';
        switch($column->AD_REFERENCE_ID)
        {
            case 10:
                //字段引用类型为 字符串
                $rs  = "<td><label for=\"$column->COLUMNNAME\">$field->NAME</label></td>";
                $colspan = ceil($field->DISPLAYLENGTH/20);
                $rs .= "<td colspan=\"$colspan\">";
                if($field->ISMANDATORYUI == 'Y'){
                    $rs .= "<input class=\"txt\" name=\"$column->COLUMNNAME\" type=\"text\" required=\"true\" value=\"$value\" id=\"$column->COLUMNNAME\">";
                }else{
                    $rs .= "<input class=\"txt\" name=\"$column->COLUMNNAME\" type=\"text\" value=\"$value\" id=\"$column->COLUMNNAME\">";
                }
                $rs .= "</td>";
                break;
            case 14:
                //字段引用类型为 文本
                $rs  = "<td><label for=\"$column->COLUMNNAME\">$field->NAME</label></td>";
                $colspan = ceil($field->DISPLAYLENGTH/20);
                $rs .= "<td colspan=\"$colspan\">";
                if($field->ISMANDATORYUI == 'Y'){
                    $rs .= "<textarea class=\"txt\" rows=\"2\" name=\"$column->COLUMNNAME\" required=\"true\" id=\"$column->COLUMNNAME\">$value</textarea>";
                }else{
                    $rs .= "<textarea class=\"txt\" rows=\"2\" name=\"$column->COLUMNNAME\" id=\"$column->COLUMNNAME\">$value</textarea>";
                }
                $rs .= "</td>";
                break;
            case 17:
                //字段引用类型为 列表
                $lists = DB::table('AD_REF_LIST')->where('AD_REFERENCE_ID', $column->AD_REFERENCE_VALUE_ID)->where('ISACTIVE', 'Y')->get();
                $rs  = "<td><label for=\"$column->COLUMNNAME\">$field->NAME</label></td>";
                $colspan = ceil($field->DISPLAYLENGTH/20);
                $rs .= "<td colspan=\"$colspan\">";
                $rs .= "<select>";
                foreach($lists as $list){
                    if($list->AD_REF_LIST_ID == $value){
                        $rs .= "<option selected value=\"$list->AD_REF_LIST_ID\">$list->NAME</option>";
                    }else{
                        $rs .= "<option value=\"$list->AD_REF_LIST_ID\">$list->NAME</option>";
                    }
                }
                $rs .= "</select>";
                $rs .= "</td>";
                break;
            case 19:
                //字段引用类型为 直接访问表
                $rs  = "<td><label for=\"$column->COLUMNNAME\">$field->NAME</label></td>";
                $colspan = ceil($field->DISPLAYLENGTH/20);
                $rs .= "<td colspan=\"$colspan\">";

                //获取引用表的表名及对象
                $ref_table_name = substr($column->COLUMNNAME, 0, -3);
                $ref_obj = DB::table($ref_table_name)->where($column->COLUMNNAME, $value)->first();
                $rs .= "<input name=\"$column->COLUMNNAME\" type=\"hidden\" value=\"$value\" id=\"$column->COLUMNNAME\">";
                if($ref_obj){
                    $rs .= "<input type=\"text\" value=\"$ref_obj->NAME\">";
                }else{
                    $rs .= "<input class=\"txt\" type=\"text\" value=\"$value\">";
                }

                $rs .= "</td>";
                break;
            case 20:
                //字段引用类型为 是/否
                $rs  = "<td><label for=\"$column->COLUMNNAME\">$field->NAME</label></td>";
                $rs .= "<td>";
                if($value == 'Y'){
                    $rs .="<input checked=\"checked\" name=\"$column->COLUMNNAME\" type=\"checkbox\" value=\"Y\" id=\"$column->COLUMNNAME\">";
                }else{
                    $rs .="<input name=\"$column->COLUMNNAME\" type=\"checkbox\" value=\"Y\" id=\"$column->COLUMNNAME\">";
                }
                $rs .= "</td>";
                break;
            case 28:
                //字段引用类型为 按钮
                $rs  = "<td></td>";
                $rs .= "<td>";
                $rs .= "<button type=\"button\">$field->NAME</button>";
                $rs .= "</td>";
                break;
            default:
                $rs  = "<td><label for=\"$column->COLUMNNAME\">$field->NAME</label></td>";
                $colspan = ceil($field->DISPLAYLENGTH/20);
                $rs .= "<td colspan=\"$colspan\">";

                if($field->ISMANDATORYUI == 'Y'){
                    $rs .= "<input class=\"txt\" name=\"$column->COLUMNNAME\" type=\"text\" required=\"true\" value=\"$value\" id=\"$column->COLUMNNAME\">";
                }else{
                    $rs .= "<input class=\"txt\" name=\"$column->COLUMNNAME\" type=\"text\" value=\"$value\" id=\"$column->COLUMNNAME\">";
                }
                $rs .= "</td>";
                break;
        }

        return $rs;
    }
}