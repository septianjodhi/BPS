$(function () {
    //Textare auto growth
    autosize($('textarea.auto-growth'));

    //Datetimepicker plugin
    $('.datetimepickerL').bootstrapMaterialDatePicker({
        format: 'dddd DD MMMM YYYY - HH:mm:ss',
        clearButton: true,
        weekStart: 1
    });
	$('.datetimepicker').bootstrapMaterialDatePicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        clearButton: true,
        weekStart: 1
    });
	$('.datepickerL').bootstrapMaterialDatePicker({
        format: 'dddd DD MMMM YYYY',
        clearButton: true,
        weekStart: 1,
        time: false
    });
    $('.datepicker').bootstrapMaterialDatePicker({
        format: 'YYYY-MM-DD',
        clearButton: true,
        weekStart: 1,
        time: false
    });
    $('.timepicker').bootstrapMaterialDatePicker({
        format: 'HH:mm:ss',
        clearButton: true,
        date: false
    });
});