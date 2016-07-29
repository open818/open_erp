<?php
/**
 * Created by PhpStorm.
 * User: kery
 * Date: 2016/7/11
 * Time: 15:17
 */
use Illuminate\Database\Seeder;

use Carbon\Carbon;

class TableSeeder extends Seeder {
    public function run()
    {
        DB::table('AD_TABLE')->insert(array(
            array(
                'AD_CLIENT_ID'  => 0,
                'AD_ORG_ID'  => 0,
                'AD_TABLE_ID'  => 100,
                'AD_WINDOW_ID'  => 100,
                'CREATED'  => Carbon::now(),
                'DESCRIPTION'  => 'Table for the Fields',
                'ENTITYTYPE'  => 'D',
                'ISACTIVE'  => 'Y',
                'ISCHANGELOG'  => 'N',
                'ISDELETEABLE'  => 'Y',
                'ISHIGHVOLUME'  => 'Y',
                'ISSECURITYENABLED'  => 'N',
                'ISVIEW'  => 'N',
                'LOADSEQ'  => 40,
                'NAME'  => 'Table',
                'TABLENAME'  => 'AD_Table',
                'UPDATED'  => Carbon::now(),
            ),
            array(
                'AD_CLIENT_ID'  => 0,
                'AD_ORG_ID'  => 0,
                'AD_TABLE_ID'  => 101,
                'AD_WINDOW_ID'  => 100,
                'CREATED'  => Carbon::now(),
                'DESCRIPTION'  => 'Column in the table',
                'ENTITYTYPE'  => 'D',
                'ISACTIVE'  => 'Y',
                'ISCHANGELOG'  => 'N',
                'ISDELETEABLE'  => 'Y',
                'ISHIGHVOLUME'  => 'N',
                'ISSECURITYENABLED'  => 'N',
                'ISVIEW'  => 'N',
                'LOADSEQ'  => 120,
                'NAME'  => 'Column',
                'TABLENAME'  => 'AD_Column',
                'UPDATED'  => Carbon::now(),
            ),
        ));
    }
}