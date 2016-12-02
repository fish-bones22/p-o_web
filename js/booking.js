$(window).ready(function () {
  $('.cancel-transaction-btn').click(function (e) {
    var parentId = $(this).parent().parent().attr('id');
    $('#reserve_code_to_cancel').val(parentId);
  });

  $('[data-toggle="popover"]').popover({ trigger: "hover", placement:"top" }); 
});
