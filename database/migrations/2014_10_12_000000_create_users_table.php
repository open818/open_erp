<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('AD_CLIENT', function (Blueprint $table) {
            $table->increments('AD_CLIENT_ID');
            $table->string('AD_LANGUAGE', 5);
            $table->integer('AD_ORG_ID');
            $table->char('AUTOARCHIVE', 1)->default('N');
            $table->dateTime('CREATED');
            $table->integer('CREATEDBY')->default('0');
            $table->string('DESCRIPTION')->nullable();
            $table->string('DOCUMENTDIR', 60)->nullable();
            $table->char('EMAILTEST', 1)->nullable();
            $table->char('ISACTIVE', 1)->default('Y');
            $table->char('ISCOSTIMMEDIATE', 1)->default('N');
            $table->char('ISMULTILINGUALDOCUMENT', 1)->default('N');
            $table->char('ISPOSTIMMEDIATE', 1)->default('N');
            $table->char('ISSERVEREMAIL', 1)->default('N');
            $table->char('ISSMTPAUTHORIZATION', 1)->default('N');
            $table->char('ISSMTPTLS', 1)->default('N');
            $table->char('ISUSEBETAFUNCTIONS', 1)->default('Y');
            $table->string('LDAPQUERY')->nullable();
            $table->char('MMPOLICY', 1)->default('F');
            $table->string('MODELVALIDATIONCLASSES')->nullable();
            $table->string('NAME', 60);
            $table->string('REQUESTEMAIL', 60)->nullable();
            $table->string('REQUESTFOLDER', 20)->nullable();
            $table->string('REQUESTUSER', 60)->nullable();
            $table->string('REQUESTUSERPW', 20)->nullable();
            $table->string('SMTPHOST', 60)->nullable();
            $table->string('SMTPPORT', 60)->default(25);
            $table->dateTime('UPDATED');
            $table->integer('UPDATEDBY')->default('0');
            $table->string('VALUE', 40)->nullable();
        });

        Schema::create('AD_ORG', function (Blueprint $table) {
            $table->integer('AD_CLIENT_ID');
            $table->increments('AD_ORG_ID');
            $table->dateTime('CREATED');
            $table->integer('CREATEDBY')->default('0');
            $table->string('DESCRIPTION')->nullable();
            $table->char('ISACTIVE', 1)->default('Y');
            $table->char('ISSUMMARY', 1)->default('N');
            $table->string('NAME', 60);
            $table->dateTime('UPDATED');
            $table->integer('UPDATEDBY')->default('0');
            $table->string('VALUE',40);
        });

        Schema::create('AD_WINDOW', function (Blueprint $table) {
            $table->integer('AD_CLIENT_ID');
            $table->integer('AD_COLOR_ID')->default('0')->nullable();
            $table->integer('AD_CTXAREA_ID')->default('0')->nullable();
            $table->integer('AD_IMAGE_ID')->default('0')->nullable();
            $table->integer('AD_ORG_ID');
            $table->increments('AD_WINDOW_ID');
            $table->dateTime('CREATED');
            $table->integer('CREATEDBY')->default('0');
            $table->string('DESCRIPTION')->nullable();
            $table->string('ENTITYTYPE', 4)->default('U');
            $table->text('HELP')->nullable();
            $table->char('ISACTIVE', 1)->default('Y');
            $table->char('ISBETAFUNCTIONALITY', 1)->default('N');
            $table->char('ISCUSTOMDEFAULT', 1)->default('N');
            $table->char('ISDEFAULT', 1)->default('N');
            $table->string('NAME', 60);
            $table->char('PROCESSING', 1)->default('N');
            $table->dateTime('UPDATED');
            $table->integer('UPDATEDBY')->default('0');
            $table->integer('WINHEIGHT')->default('0');
            $table->integer('WINWIDTH')->default('0');
            $table->char('WINDOWTYPE',1)->default('M');
        });

        Schema::create('AD_WINDOW_TRL', function (Blueprint $table) {
            $table->integer('AD_CLIENT_ID');
            $table->string('AD_LANGUAGE', 5);
            $table->integer('AD_ORG_ID');
            $table->integer('AD_WINDOW_ID');
            $table->dateTime('CREATED');
            $table->integer('CREATEDBY')->default('0');
            $table->string('DESCRIPTION')->nullable();
            $table->text('HELP')->nullable();
            $table->char('ISACTIVE', 1)->default('Y');
            $table->char('ISTRANSLATED', 1)->default('N');
            $table->string('NAME', 60);
            $table->dateTime('UPDATED');
            $table->integer('UPDATEDBY')->default('0');
        });

        Schema::create('AD_TAB', function (Blueprint $table) {
            $table->integer('AD_CLIENT_ID');
            $table->integer('AD_COLUMNSORTORDER_ID')->nullable();
            $table->integer('AD_COLUMNSORTYESNO_ID')->nullable();
            $table->integer('AD_COLUMN_ID')->nullable();
            $table->integer('AD_CTXAREA_ID')->nullable();
            $table->integer('AD_IMAGE_ID')->nullable();
            $table->integer('AD_ORG_ID');
            $table->integer('AD_PROCESS_ID')->nullable();
            $table->increments('AD_TAB_ID');
            $table->integer('AD_TABLE_ID');
            $table->integer('AD_WINDOW_ID');
            $table->text('COMMITWARNING')->nullable();
            $table->dateTime('CREATED');
            $table->integer('CREATEDBY')->default('0');
            $table->string('DESCRIPTION')->nullable();
            $table->text('DISPLAYLOGIC')->nullable();
            $table->string('ENTITYTYPE',4)->default('U');
            $table->char('HASTREE', 1)->default('N');
            $table->text('HELP')->nullable();
            $table->char('IMPORTFIELDS', 1)->nullable();
            $table->integer('INCLUDED_TAB_ID')->nullable();
            $table->char('ISACTIVE', 1)->default('Y');
            $table->char('ISADVANCEDTAB', 1)->default('N');
            $table->char('ISDISPLAYED', 1)->default('Y')->comment('是否显示');
            $table->char('ISINFOTAB', 1)->default('N');
            $table->char('ISINSERTRECORD', 1)->default('Y');
            $table->char('ISREADONLY', 1)->default('N');
            $table->char('ISSINGLEROW', 1)->default('N');
            $table->char('ISSORTTAB', 1)->default('N');
            $table->char('ISTRANSLATIONTAB', 1)->default('N');
            $table->string('NAME', 60);
            $table->text('ORDERBYCLAUSE')->nullable();
            $table->char('PROCESSING', 1)->default('N');
            $table->text('READONLYLOGIC')->nullable();
            $table->integer('REFERENCED_TAB_ID')->nullable();
            $table->integer('SEQNO');
            $table->integer('TABLEVEL')->default('0');
            $table->dateTime('UPDATED');
            $table->integer('UPDATEDBY')->default('0');
            $table->text('WHERECLAUSE')->nullable();
        });

        Schema::create('AD_TAB_TRL', function (Blueprint $table) {
            $table->integer('AD_CLIENT_ID');
            $table->string('AD_LANGUAGE', 5);
            $table->integer('AD_ORG_ID');
            $table->integer('AD_TAB_ID');
            $table->text('COMMITWARNING')->nullable();
            $table->dateTime('CREATED');
            $table->integer('CREATEDBY')->default('0');
            $table->string('DESCRIPTION')->nullable();
            $table->text('HELP')->nullable();
            $table->char('ISACTIVE', 1)->default('Y');
            $table->char('ISTRANSLATED', 1)->default('N');
            $table->string('NAME', 60);
            $table->dateTime('UPDATED');
            $table->integer('UPDATEDBY')->default('0');
        });

        Schema::create('AD_FIELD', function (Blueprint $table) {
            $table->integer('AD_CLIENT_ID');
            $table->integer('AD_COLUMN_ID')->nullable();
            $table->integer('AD_FIELDGROUP_ID')->nullable();
            $table->increments('AD_FIELD_ID');
            $table->integer('AD_ORG_ID');
            $table->integer('AD_REFERENCE_ID')->nullable();
            $table->integer('AD_TAB_ID');
            $table->dateTime('CREATED');
            $table->integer('CREATEDBY')->default('0');
            $table->string('DEFAULTVALUE')->nullable();
            $table->string('DESCRIPTION')->nullable();
            $table->integer('DISPLAYLENGTH')->nullable()->comment('显示长度');
            $table->text('DISPLAYLOGIC')->nullable();
            $table->string('ENTITYTYPE',4)->default('U');
            $table->text('HELP')->nullable();
            $table->char('ISACTIVE', 1)->default('Y');
            $table->char('ISCENTRALLYMAINTAINED', 1)->default('Y');
            $table->char('ISDEFAULTFOCUS', 1)->default('N')->comment('是否默认焦点');
            $table->char('ISDISPLAYED', 1)->default('Y')->comment('是否显示');
            $table->char('ISENCRYPTED', 1)->default('N')->comment('是否加密');
            $table->char('ISFIELDONLY', 1)->default('N')->comment('是否仅显示字段');
            $table->char('ISHEADING', 1)->default('N')->comment('是否仅显示标题');
            $table->char('ISMANDATORYUI', 1)->default('N')->comment('是否界面必填');
            $table->char('ISREADONLY', 1)->default('N')->comment('是否只读');
            $table->char('ISSAMELINE', 1)->default('N')->comment('是否相同行');
            $table->integer('MRSEQNO')->nullable();
            $table->string('NAME', 60);
            $table->char('OBSCURETYPE', 3)->nullable();
            $table->integer('SEQNO')->nullable()->comment('序号');
            $table->integer('SORTNO')->nullable();
            $table->dateTime('UPDATED');
            $table->integer('UPDATEDBY')->default('0');
        });

        Schema::create('AD_TABLE', function (Blueprint $table) {
            $table->integer('AD_CLIENT_ID');
            $table->integer('AD_ORG_ID');
            $table->increments('AD_TABLE_ID');
            $table->integer('AD_VAL_RULE_ID')->nullable();
            $table->integer('AD_WINDOW_ID')->nullable();
            $table->char('ACCESSLEVEL', 1)->default('4');
            $table->dateTime('CREATED');
            $table->integer('CREATEDBY')->default('0');
            $table->string('DESCRIPTION')->nullable();
            $table->string('ENTITYTYPE',4)->default('U');
            $table->text('HELP')->nullable();
            $table->char('IMPORTTABLE', 1)->nullable()->comment('产生来自数据库的列');
            $table->char('ISACTIVE', 1)->default('Y');
            $table->char('ISCHANGELOG', 1)->default('N');
            $table->char('ISDELETEABLE', 1)->default('Y');
            $table->char('ISHIGHVOLUME', 1)->default('N');
            $table->char('ISSECURITYENABLED', 1)->default('N');
            $table->char('ISVIEW', 1)->default('N');
            $table->integer('LOADSEQ')->nullable();
            $table->string('NAME', 60);
            $table->integer('PO_WINDOW_ID')->nullable();
            $table->integer('REFERENCED_TABLE_ID')->nullable();
            $table->char('REPLICATIONTYPE', 1)->default('L');
            $table->string('TABLENAME', 40);
            $table->dateTime('UPDATED');
            $table->integer('UPDATEDBY')->default('0');
        });

        Schema::create('AD_COLUMN', function (Blueprint $table) {
            $table->integer('AD_CLIENT_ID');
            $table->increments('AD_COLUMN_ID');
            $table->integer('AD_ELEMENT_ID')->nullable();
            $table->integer('AD_ORG_ID');
            $table->integer('AD_PROCESS_ID')->nullable();
            $table->integer('AD_REFERENCE_ID');
            $table->integer('AD_REFERENCE_VALUE_ID')->nullable();
            $table->integer('AD_TABLE_ID');
            $table->integer('AD_VAL_RULE_ID')->nullable();
            $table->string('CALLOUT')->nullable()->comment('输入回调方法');
            $table->string('COLUMNNAME',40);
            $table->text('COLUMNSQL')->nullable()->comment('虚拟列SQL');
            $table->char('CONSTRAINTTYPE', 1)->nullable();
            $table->dateTime('CREATED');
            $table->integer('CREATEDBY')->default('0');
            $table->string('DEFAULTVALUE')->nullable()->comment('默认值');
            $table->string('DESCRIPTION')->nullable();
            $table->string('ENTITYTYPE',4)->default('U');
            $table->integer('FIELDLENGTH')->nullable();
            $table->text('HELP')->nullable();
            $table->char('ISACTIVE', 1)->default('Y')->comment('是否有效');
            $table->char('ISALWAYSUPDATEABLE', 1)->default('N')->comment('是否总是允许修改');
            $table->char('ISCALLOUT', 1)->default('N')->comment('是否回调');
            $table->char('ISENCRYPTED', 1)->default('N');
            $table->char('ISIDENTIFIER', 1)->default('N');
            $table->char('ISKEY', 1)->default('N')->comment('是否关键列');
            $table->char('ISMANDATORY', 1)->default('N')->comment('是否保存强制性的');
            $table->char('ISMANDATORYUI', 1)->default('N')->comment('是否界面强制性的');
            $table->char('ISPARENT', 1)->default('N')->comment('是否父表关联');
            $table->char('ISRECURSIVEFK', 1)->default('N');
            $table->char('ISSELECTIONCOLUMN', 1)->default('N');
            $table->char('ISSUMMARYCOLUMN', 1)->default('N');
            $table->char('ISSYNCDATABASE', 1)->nullable();
            $table->char('ISTRANSLATED', 1)->default('N');
            $table->char('ISUPDATEABLE', 1)->default('Y')->comment('是否可修改');
            $table->text('MANDATORYLOGIC')->nullable();
            $table->string('NAME', 60);
            $table->text('READONLYLOGIC')->nullable()->comment('只读逻辑');
            $table->integer('SELECTIONSEQNO')->nullable();
            $table->integer('SEQNO')->nullable();
            $table->integer('SUMMARYSEQNO')->nullable();
            $table->integer('TABLEUID')->nullable();
            $table->dateTime('UPDATED');
            $table->integer('UPDATEDBY')->default('0');
            $table->string('VFORMAT',60)->nullable();
            $table->string('VALUEMAX',20)->nullable();
            $table->string('VALUEMIN',20)->nullable();
            $table->integer('VERSION')->default('0');
        });

        Schema::create('AD_REFERENCE', function (Blueprint $table) {
            $table->integer('AD_CLIENT_ID');
            $table->integer('AD_ORG_ID');
            $table->increments('AD_REFERENCE_ID');
            $table->dateTime('CREATED');
            $table->integer('CREATEDBY')->default('0');
            $table->string('DESCRIPTION')->nullable();
            $table->string('ENTITYTYPE',4)->default('U');
            $table->text('HELP')->nullable();
            $table->char('ISACTIVE', 1)->default('Y');
            $table->string('NAME', 60);
            $table->dateTime('UPDATED');
            $table->integer('UPDATEDBY')->default('0');
            $table->string('VFORMAT', 40)->nullable();
            $table->char('VALIDATIONTYPE', 1);
        });

        Schema::create('AD_REF_TABLE', function (Blueprint $table) {
            $table->integer('AD_CLIENT_ID');
            $table->integer('AD_ORG_ID');
            $table->integer('AD_REFERENCE_ID');
            $table->integer('AD_TABLE_ID');
            $table->integer('COLUMN_DISPLAY_ID');
            $table->integer('COLUMN_KEY_ID');
            $table->dateTime('CREATED');
            $table->integer('CREATEDBY')->default('0');
            $table->string('DESCRIPTION')->nullable();
            $table->string('ENTITYTYPE',4)->default('U');
            $table->char('ISACTIVE', 1)->default('Y');
            $table->char('ISVALUEDISPLAYED', 1)->default('N');
            $table->text('ORDERBYCLAUSE')->nullable();
            $table->dateTime('UPDATED');
            $table->integer('UPDATEDBY')->default('0');
            $table->text('WHERECLAUSE')->nullable();
        });

        Schema::create('AD_REF_LIST', function (Blueprint $table) {
            $table->integer('AD_CLIENT_ID');
            $table->integer('AD_ORG_ID');
            $table->increments('AD_REF_LIST_ID');
            $table->integer('AD_REFERENCE_ID');
            $table->dateTime('CREATED');
            $table->integer('CREATEDBY')->default('0');
            $table->string('DESCRIPTION')->nullable();
            $table->string('ENTITYTYPE',4)->default('U');
            $table->char('ISACTIVE', 1)->default('Y');
            $table->string('NAME', 60);
            $table->dateTime('UPDATED');
            $table->integer('UPDATEDBY')->default('0');
            $table->dateTime('VALIDFROM')->nullable();
            $table->dateTime('VALIDTO')->nullable();
            $table->string('VALUE');
        });

        Schema::create('AD_VAL_RULE', function (Blueprint $table) {
            $table->integer('AD_CLIENT_ID');
            $table->integer('AD_ORG_ID');
            $table->increments('AD_VAL_RULE_ID');
            $table->text('CODE');
            $table->dateTime('CREATED');
            $table->integer('CREATEDBY')->default('0');
            $table->string('DESCRIPTION')->nullable();
            $table->string('ENTITYTYPE',4)->default('U');
            $table->char('ISACTIVE', 1)->default('Y');
            $table->string('NAME', 60);
            $table->char('TYPE', 1);
            $table->dateTime('UPDATED');
            $table->integer('UPDATEDBY')->default('0');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('AD_CLIENT');
        Schema::dropIfExists('AD_ORG');
        Schema::dropIfExists('AD_WINDOW');
        Schema::dropIfExists('AD_WINDOW_TRL');
        Schema::dropIfExists('AD_TAB');
        Schema::dropIfExists('AD_TAB_TRL');
        Schema::dropIfExists('AD_FIELD');
        Schema::dropIfExists('AD_TABLE');
        Schema::dropIfExists('AD_COLUMN');
        Schema::dropIfExists('AD_REFERENCE');
        Schema::dropIfExists('AD_REF_TABLE');
        Schema::dropIfExists('AD_REF_LIST');
        Schema::dropIfExists('AD_VAL_RULE');
    }
}
