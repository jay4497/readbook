define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'record/index' + location.search,
                    add_url: 'record/add',
                    edit_url: 'record/edit',
                    del_url: 'record/del',
                    multi_url: 'record/multi',
                    import_url: 'record/import',
                    table: 'record',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'weigh',
                search: false,
                fixedColumns: true,
                fixedRightNumber: 1,
                showExport: false,
                showToggle: false,
                showColumns: false,
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'content_id', title: __('Content_id'), addclass: 'selectpage', extend: 'data-source="content/index" data-field="title" data-multiple="false" autocomplete="off"', visible: false},
                        {field: 'content_title', title: __('Content_id'), operate: false},
                        {field: 'audio', title: __('Audio'), operate: false, formatter: Controller.api.audio},
                        {field: 'text', title: __('Text'), operate: false, formatter: Table.api.formatter.content},
                        {field: 'flag', title: __('Flag')},
                        {field: 'weigh', title: __('Weigh'), operate: false},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        add_multi: function() {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"), null, null, () => {
                    var text = $('#c-text').val();
                    var audio = $('#c-audio').val();
                    var text_segments = text.split('\\r\\n');
                    var audio_segments = audio.split(',');
                    console.log(text_segments);
                    console.log(audio_segments);
                    if (text_segments.length !== audio_segments.length) {
                        console.log('false');
                        Toastr.error(__('Text pieces are not equal to audio\'s'));
                        return false;
                    }
                });
            },
            audio: function(val, row, index) {
                if (val) {
                    return '<audio controls><source src="' + Fast.api.cdnurl(val) + '"></audio>';
                }
                return '';
            }
        }
    };
    return Controller;
});
