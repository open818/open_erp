<!DOCTYPE html>
<html>
    <head>
        <title></title>
        {{Html::style('vendor/bootstrap/css/bootstrap.css')}}
        {{Html::style('vendor/jquery-ui/jquery-ui.min.css')}}
        {{Html::style('vendor/jqGrid/css/ui.jqgrid.css')}}
        {{Html::style('css/erp.css')}}
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

        {{Html::script('vendor/jquery/jquery-3.0.0.min.js') }}
        {{Html::script('vendor/jquery-ui/jquery-ui.min.js')}}
        {{Html::script('vendor/bootstrap/js/bootstrap.js') }}
        {{Html::script('vendor/jqGrid/js/jquery.jqGrid.min.js') }}
        {{Html::script('vendor/jqGrid/js/i18n/grid.locale-cn.js') }}
        {{Html::script('vendor/layer/layer.js') }}
        {{Html::script('js/erp.js') }}
        {{Html::script('vendor/jquery/jquery.validate.min.js') }}
        <script type="application/javascript">
            var select_kv = {};

            $(document).ready(function(e) {
                SidebarTabHandler.Init();
                $('#toggle_btn').click(function(){
                    curr_tab = $(".tabItemCurrent").parent('li');
                    var table_id = curr_tab.attr('data-table_id');
                    $('#table_'+table_id).bootstrapTable('toggleView');
                });

                $('#add_btn').click(function(){
                    ADWindow.create();
                });

                $('#edit_btn').click(function(){
                    ADWindow.edit();
                });

                $('#reload_btn').click(function(){
                    ADWindow.reload(select_kv);
                });
            });
            var SidebarTabHandler={
                Init:function(){
                    $(".tabItemContainer>li").click(function(){
                        old_tab = ADWindow.currTab();
                        rowData = ADWindow.selectRow();
                        if(rowData){
                            select_kv[old_tab.table_id_name] = rowData[old_tab.table_id_name];
                        }

                        $(".tabItemContainer>li>a").removeClass("tabItemCurrent");
                        $(".tabBodyItem").removeClass("tabBodyCurrent");
                        $(this).find("a").addClass("tabItemCurrent");
                        var item = $($(".tabBodyItem")[$(this).index()]);
                        item.addClass("tabBodyCurrent");

                        curr_tab = ADWindow.currTab();
                        if(curr_tab.loaded == '1'){
                            if(parent == ''){
                                return;
                            }else{
                                var v = '';
                                parents = curr_tab.parents.split(',');
                                for(var p in parents){
                                    v = select_kv[parents[p]]+',';
                                }
                                if(curr_tab.parents_value == v){
                                    return ;
                                }else{
                                    $(this).attr('data-table_parent_value', v);
                                }
                            }
                        }else{
                            new_tab = ADWindow.currTab();
                            var new_width = $('#gbox_table_'+old_tab.table_id).css('width');
                            new_width = parseInt(new_width);
                            $('#table_'+new_tab.table_id).setGridParam({
                                url: '/_develop/getTableDate/'+new_tab.table_id,
                                postData: select_kv,
                                datatype:'json'
                            }).setGridWidth(new_width).trigger("reloadGrid");
                        }
                    });
                }
            }
        </script>
    </head>
    <body>
        <div class="container">

            <div class="content wrapper wrapper-content">
                <div id="tools" class="row">
                    <button id="add_btn">新增</button>
                    <button id="edit_btn">修改</button>
                    <button>删除</button>
                    <button>查看</button>
                    <button id="reload_btn">刷新</button>
                </div>

                <div class="row" style="height: 900px;">
                    <div class="col-xs-12" style="margin-top: 20px;">
                        <div class="col-xs-1 tabItemContainer" style="padding: 0;">
                            @php($i=1)
                            @foreach($tabs as $tab)
                                <li data-tab_id="{{$tab->AD_TAB_ID}}"
                                    data-table_id="{{$tab->AD_TABLE_ID}}"
                                    data-table_id_name="{{$tab->id_name}}"
                                    data-table_parent="{{implode(',',$tab->parent_names)}}"
                                    @if($i==1) data-loaded=1 @else data-loaded=0 @endif
                                        >
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
                                    <table class="col-xs-11" id="table_{{$tab->AD_TAB_ID}}"></table>
                                    <script type="application/javascript">
                                        $("#table_{{$tab->AD_TAB_ID}}").jqGrid({
                                            @if($i == 1)
                                            url:"/_develop/getTableDate/{{$tab->AD_TAB_ID}}",
                                            @endif
                                            datatype : "json",
                                            mtype: 'GET',
                                            rowNum: '-1',
                                            height: 400,
                                            /* width: 700,*/
                                            shrinkToFit:false,
                                            rownumbers: true,
                                            colModel:[
                                                @foreach($tab->fields as $field)
                                                {
                                                    name : '{{$field->COLUMNNAME}}',
                                                    label: '{{$field->NAME}}',
                                                    index : '{{$field->COLUMNNAME}}',
                                                    sortable: true,
                                                    sort: ''
                                                },
                                                @endforeach
                                            ],
                                            autowidth: true,
                                            regional : 'cn',
                                            sortable: true,
                                            loadonce: true
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

