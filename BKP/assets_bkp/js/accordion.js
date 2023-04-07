function toggleChevron(e) {
    $(e.target)
        .prev('.panel-heading')
        .find("i.indicator.glyphicon")
        .toggleClass('glyphicon-chevron-down glyphicon-chevron-up');
}
$('#accordion').on('hidden.bs.collapse', toggleChevron);
$('#accordion').on('shown.bs.collapse', toggleChevron);

$(function() {
  $("#listView li").click(function () {
    if ( $("#listView li").hasClass("list-item-active") ) {
      $("#listView li").removeClass("list-item-active");
    }
    $(this).addClass("list-item-active");
  });
});

$(function(){
  $('.pop').click(function(){
    $('.overlay').addClass('is-open');
    return false;
  });

  $('.closeBtn').click(function(){
    $('.overlay').removeClass('is-open');
  });
});
