define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'shop/index' + location.search,
                    add_url: 'shop/add',
                    edit_url: 'shop/edit',
                    del_url: 'shop/del',
                    multi_url: 'shop/multi',
                    table: 'booth_shop',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'weigh',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'user_id', title: __('User_id')},
                        {field: 'shopname', title: __('Shopname')},
                        {field: 'keywords', title: __('Keywords')},
                        {field: 'description', title: __('Description')},
                        {field: 'service_ids', title: __('Service_ids')},
                        {field: 'avatar', title: __('Avatar'), events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'state', title: __('State'), searchList: {"0":__('State 0'),"1":__('State 1'),"2":__('State 2')}, formatter: Table.api.formatter.normal},
                        {field: 'level', title: __('Level')},
                        {field: 'islive', title: __('Islive')},
                        {field: 'isself', title: __('Isself')},
                        {field: 'city', title: __('City')},
                        {field: 'return', title: __('Return')},
                        {field: 'like', title: __('Like')},
                        {field: 'score_describe', title: __('Score_describe'), operate:'BETWEEN'},
                        {field: 'score_service', title: __('Score_service'), operate:'BETWEEN'},
                        {field: 'score_deliver', title: __('Score_deliver'), operate:'BETWEEN'},
                        {field: 'score_logistics', title: __('Score_logistics'), operate:'BETWEEN'},
                        {field: 'weigh', title: __('Weigh')},
                        {field: 'verify', title: __('Verify'), searchList: {"0":__('Verify 0'),"1":__('Verify 1'),"2":__('Verify 2'),"3":__('Verify 3'),"4":__('Verify 4')}, formatter: Table.api.formatter.normal},
                        {field: 'created', title: __('Created')},
                        {field: 'modified', title: __('Modified')},
                        {field: 'deleted', title: __('Deleted')},
                        {field: 'status', title: __('Status'), searchList: {"normal":__('Normal'),"hidden":__('Hidden')}, formatter: Table.api.formatter.status},
                        {field: 'name', title: __('Name')},
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
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});