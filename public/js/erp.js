var Message =
{
    showMsg : function(msg){
        layer.msg(msg);
    }
}

var ADTab = function(obj)
{
    this.tab_id = obj.attr('data-tab_id');
    this.table_id = obj.attr('data-table_id');
    this.table_id_name = obj.attr('data-table_id_name');
    this.parents = obj.attr('data-table_parent');
    this.parents_value = obj.attr('data-table_parent_value');
    this.loaded = obj.attr('data-loaded');
}

var ADWindow =
{
    currTab : function(){
        return new ADTab($(".tabItemCurrent").parent('li'));
    },

    selectRow : function(){
        table_id = this.currTab().table_id;
        var rowid=$('#table_'+ table_id).jqGrid("getGridParam","selrow");
        if(rowid > 0){
            var rowData = $('#table_'+table_id).jqGrid('getRowData',rowid);
            return rowData;
        }
        return false;
    },

    reload : function(select_kv){
        tab = this.currTab().table_id;

        $('#table_' + table_id).setGridParam({
            url: '/_develop/getTableDate/'+tab.tab_id+'/'+tab.table_id,
            postData: select_kv,
            datatype:'json'
        }).trigger("reloadGrid");
    },

    create : function(select_kv){
        table_id = this.currTab().table_id;

        $.get('/_develop/edit/'+table_id, {}, function(str){
            layer.open({
                type: 1,
                title: 'title',
                area: '800px',
                closeBtn: 2,
                content: str,
                btn: ['保存'],
                skin: 'demo-class',
                yes: function(index, layero){
                    $('*').removeClass("error");
                    $("#window_form").validate({
                        errorPlacement: function (error, element) {
                            element.addClass("error");
                        }
                    });
                    if($("#window_form").valid()){
                        ADWindow.save(index);
                    }
                },
                cancel : function(){
                    ADWindow.reload(select_kv);
                },
            });
        });
    },

    edit : function(select_kv){
        tab = this.currTab();
        select = this.selectRow();

        if(select){
            $.get('/_develop/edit/'+tab.table_id + '/' + select[tab.table_id_name], {}, function(str){
                layer.open({
                    type: 1,
                    title: 'title',
                    area: '800px',
                    closeBtn: 2,
                    content: str,
                    btn: ['保存'],
                    skin: 'demo-class',
                    yes: function(index, layero){
                        $("#window_form").validate({
                            errorPlacement: function (error, element) {
                                alert(error.html());
                            }
                        });
                        if($("#window_form").valid()){
                            ADWindow.save(index);
                        }
                    },
                    cancel : function(){
                        ADWindow.reload(select_kv);
                    },
                });
            });
        }else{
            Message.showMsg('请先选择需要编辑的记录！');
        }
    },

    save : function(index){
        $.post("/_develop/edit/save",$('#window_form').serialize(),function(result){
            if(result == 'success'){
                ADWindow.reload(select_kv);
                layer.close(index);
                Message.showMsg('保存成功！');
            }else{
                Message.showMsg(result);
            }
        });
    }
}