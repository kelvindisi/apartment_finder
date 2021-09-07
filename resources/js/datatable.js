const { includes } = require("lodash");

const $ = require("../../node_modules/jquery");
const DataTable = require("../../node_modules/datatables.net-bs5/js/dataTables.bootstrap5");

$(function(){
    $(".dt-table").DataTable()
});