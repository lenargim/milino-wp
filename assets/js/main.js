$ = jQuery;

$(document).ready(function () {
// Mask
//   $('input[type="tel"]').mask('+0000-000-00-00-00-00-00');

  $('.category-hover').on('mouseenter', function () {
    const categoryType = $(this).attr('for');
    changeCategoryImg(categoryType);
  })

  $('.category-hover').on('mouseleave', function () {
    const cabInput = $('.filter-cabinets:checked').attr('id');
    changeCategoryImg( cabInput ? cabInput : 'default-cabinets');
  })
})


function changeCategoryImg(type) {
  $('#category-img').attr('src', `${object_name.templateUrl}/assets/img/${type}.png`);
}