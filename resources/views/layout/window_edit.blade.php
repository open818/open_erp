
<style>
    .edit_window{
        background-color:#F9EE70;
        padding: 5px 0;
        font-family:"微软雅黑";
        -webkit-box-shadow:4px 4px 5px #333;/*webkit*/
        -moz-box-shadow:4px 4px 5px #333;/*firefox*/
        box-shadow:4px 4px 5px #333;/*opera或ie9*/
    }

    #title{
        width:200px;
        margin:20px auto;
    }

    #title legend{
        font-size:26px;
    }

    .edit_window .title{
        background-color:#F9EE70;
        width:680px;
        height:20px;
    }

    .edit_window .title img{
        float:right;
        margin:-15px 10px;
    }

    /*-----------form-----------*/

    .edit_window fieldset{
        width:95%;
        border:1px dashed #666;
        margin:10px auto;
    }

    .edit_window legend{
        background-color:#F9EE70;
        width: auto;
        height:30px;
        color:#630;
        font-weight:bolder;
        font-size:20px;
        line-height:30px;
        margin:-20px 10px 10px;
        padding:0 10px;
        border: 0;
    }
    .edit_window tr{
        margin:10px;
    }

    .edit_window tr td{
        padding: 5px 5px;
    }

    .edit_window tr label{
        height:20px;
        font-size:12px;
        line-height:15px;
        margin:0 5px;
        float : right;
    }

    .txt{
        background-color:#F9EE70;
        color:#333;
        width: 100%;
        font-size:16px;
        line-height:20px;
        border:none;
        border-bottom:1px solid #565656;
    }

    .txt:focus{
        color:#333;
        background-color: #FF0;
        border-bottom:1px solid #F00;
    }

    select{
        width:100px;
    }

    option{
        text-align:center;
    }

    input.btn{
        width:50px;
        height:20px;
        color:#00008B;
        background-color: transparent;
        border:0;
        padding:0;
    }

    input.error{
        background-color: #ff0000;
    }
</style>

<div class="edit_window">
    {!! Form::open(array('id'=>'window_form')) !!}
    {!! Form::hidden('table_id', $table_id) !!}
    {!! Form::hidden('record_id', $record_id) !!}
    <fieldset>
        <legend>收件信息</legend>
        <table>
            <tr>
            @php($i = 1)
            @foreach($fields as $field)
                @if($field->ISSAMELINE=='N' && $i != 1)
                </tr><tr>
                @endif

                @if($record_id)
                    @php($column_name=strtoupper($field->COLUMNNAME))
                    @php($field_value=$table_datas->$column_name)
                @else
                    @php($field_value=null)
                @endif

                {!! \App\Http\Core\ReferenceHelp::htmlTag($field->AD_FIELD_ID, $field_value) !!}

                @php($i++)
            @endforeach
            </tr>
        </table>

    </fieldset>

    {!! Form::close() !!}
</div>
