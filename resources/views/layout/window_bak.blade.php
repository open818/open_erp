<!DOCTYPE html>
<html>
    <head>
        <title></title>
        {{Html::script('vendor/jquery/jquery-3.0.0.js') }}
        {{Html::script('vendor/bootstrap/js/bootstrap.js') }}
        {{Html::script('vendor/bootstrap/js/bootstrap-table.js') }}
        {{Html::script('vendor/bootstrap/js/bootstrap-table-zh-CN.js') }}

        {{Html::script('vendor/jquery/jquery.easyui.min.js') }}

        {{Html::style('vendor/bootstrap/css/bootstrap.css')}}
        {{Html::style('vendor/bootstrap/js/bootstrap-table.css') }}

        <style type="text/css">
            .tabItemContainer {
            }
            .tabBodyContainer {
                /*width: 677px;*/
                /*height: 500px;*/
                float: left;
                background-color: #fff;
                border: 1px solid #ccc;
                -webkit-border-radius: 0 5px 5px 0;
                -moz-border-radius: 0 5px 5px 0;
                border-radius: 0 5px 5px 0;
                margin-left: -1px;
            }
            .tabItemContainer>li {
                list-style: none;
                text-align: center;
            }
            .tabItemContainer>li>a {
                float: left;
                width: 100%;
                padding: 10px 0 10px 0;
                font: 16px "微软雅黑", Arial, Helvetica, sans-serif;
                color: #808080;
                cursor: pointer;
                text-decoration: none;
                border:1px solid transparent;
            }
            .tabItem {
                background-color: #efefef;
            }
            .tabItemCurrent {
                background-color: #fff;
                border: 1px solid #ccc !important;
                border-right: 1px solid #fff !important;
                position: relative;
                -webkit-border-radius: 5px 0 0 5px;
                -moz-border-radius: 5px 0 0 5px;
                border-radius: 5px 0 0 5px;
            }
            .tabItemContainer>li>a:hover {
                color: #333;
            }
            .tabBodyItem {
                position: absolute;
                width: 100%;
                height: 500px;
                display: none;
            }
            .tabBodyItem>p {
                font: 13px "微软雅黑", Arial, Helvetica, sans-serif;
                text-align: center;
                margin-top: 30px;
            }
            .tabBodyItem>p>a {
                text-decoration: none;
                color: #0F3;
            }
            .tabBodyCurrent{
                display:block;
            }
        </style>

        <script type="application/javascript">
            var select_kv = {};

            $(document).ready(function(e) {
                SidebarTabHandler.Init();
                $('#toggle_btn').click(function(){
                    curr_tab = $(".tabItemCurrent").parent('li');
                    var table_id = curr_tab.attr('data-table_id');
                    $('#table_'+table_id).bootstrapTable('toggleView');
                });
            });
            var SidebarTabHandler={
                Init:function(){
                    $(".tabItemContainer>li").click(function(){
                        old_tab = $(".tabItemCurrent").parent('li');
                        var tab_id = old_tab.attr('data-tab_id');
                        var table_id = old_tab.attr('data-table_id');
                        var table_id_name = old_tab.attr('data-table_id_name');

                        var selectRow = $('#table_'+table_id).bootstrapTable('getSelections');
                        if(selectRow.length > 0){
                            $.each(selectRow, function(i, item){
                                select_kv[table_id_name] = item[table_id_name];
                            });
                        }

                        $(".tabItemContainer>li>a").removeClass("tabItemCurrent");
                        $(".tabBodyItem").removeClass("tabBodyCurrent");
                        $(this).find("a").addClass("tabItemCurrent");
                        var item = $($(".tabBodyItem")[$(this).index()]);
                        item.addClass("tabBodyCurrent");

                        var new_table_id = $(this).attr('data-table_id');
                        $('#table_'+new_table_id).bootstrapTable('refresh', {query: select_kv});
                    });
                }
            }
        </script>
    </head>
    <body>
        <div class="container">

            <div class="content wrapper wrapper-content">
                <div id="tools" class="row">
                    <button>新增</button>
                    <button>保存</button>
                    <button>修改</button>
                    <button>删除</button>
                    <button id="toggle_btn">视图切换</button>
                    <button>查看</button>
                    <button>刷新</button>
                </div>

                <div class="row" style="height: 900px;">
                    <div class="col-xs-12" style="margin-top: 20px;">
                        <div class="col-xs-1 tabItemContainer" style="padding: 0;">
                            @php($i=1)
                            @foreach($tabs as $tab)
                                <li data-tab_id="{{$tab->AD_TAB_ID}}" data-table_id="{{$tab->AD_TABLE_ID}}" data-table_id_name="{{$tab->id_name}}">
                                    <a class="tabItem @if($i == 1) tabItemCurrent @endif"  href="#home" data-toggle="tab">
                                        {{$tab->NAME}}
                                    </a>
                                </li>
                                @php($i++)
                            @endforeach
                        </div>
                        <div class="col-xs-11 tabBodyContainer" style="padding: 0;">
                            @php($i=1)
                            @foreach($tabs as $tab)
                                <div class="tabBodyItem @if($i==1) tabBodyCurrent @endif">
                                    <table id="table_{{$tab->AD_TAB_ID}}" data-toggle="table"></table>
                                    <script type="application/javascript">
                                        $("#table_{{$tab->AD_TAB_ID}}").bootstrapTable({
                                            singleSelect: true,
                                            height: 700,
                                            clickToSelect: true,
                                            showFooter: true,
                                            columns:[
                                                {
                                                    radio : true,
                                                },
                                                {
                                                    field : 'Number',
                                                    title : '行号',
                                                    formatter : function(value, row, index) {
                                                        return index + 1;
                                                    }
                                                },
                                                @foreach($tab->fields as $field)
                                                {
                                                    field : '{{$field->COLUMNNAME}}',
                                                    title : '{{$field->NAME}}',
                                                    sortable : true,
                                                },
                                                @endforeach
                                            ],
                                            url:"/_develop/getTableDate/{{$tab->AD_TAB_ID}}",
                                        });
                                    </script>
                                </div>
                                @php($i++)
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
