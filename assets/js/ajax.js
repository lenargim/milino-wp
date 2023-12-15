$(document).ready(function () {
  const ajax_url = window.ajaxVar.ajaxurl || false;
  const steps = [
    {
      slug: 'room',
      name: 'Room',
      isMain: 1,
      type: 'product_cat',
    },
    // {
    //   slug: 'cabinet-type',
    //   name: 'Cabinet type',
    //   isMain: 0,
    //   type: 'product_cat',
    // },
    {
      slug: 'door-type',
      name: 'Door Type',
      isMain: 1,
      type: 'door',
    },
    {
      slug: 'finish-material',
      name: 'Door Finish Material',
      isMain: 0,
      type: 'door',
    },
    {
      slug: 'finish-color',
      name: 'Door Finish Color',
      isMain: 0,
      type: 'door',
    },
    {
      slug: 'box-material',
      name: 'Box Material',
      isMain: 1,
      type: 'box_material',
    },
    {
      slug: 'drawer-brand',
      name: 'Drawer Brand',
      isMain: 1,
      type: 'drawer',
    },
    {
      slug: 'drawer-type',
      name: 'Drawer Type',
      isMain: 0,
      type: 'drawer',
    },
    {
      slug: 'drawer-color',
      name: 'Drawer Color',
      isMain: 0,
      type: 'drawer',
    },
  ];
  $('#order-form').on('change', '.show__row-input', function () {
    const parent_id = +$(this).data('id');
    const block = $(this).parents('.shop__block');
    block.nextAll().remove();

    const currentStep = block.attr('id');
    const current = steps.find(step => step.slug === currentStep);
    const nextStepIndex = steps.indexOf(current) + 1
    const nextStep = steps[nextStepIndex];

    const inputs = $('#order-form :input:checked');

    const lastInput = $('input[name="drawer-color"]');

    $('.sidebar__alert').remove();
    $('.button.submit').remove();

    if (lastInput.length && lastInput.val() !== '') {

      let category = '';
      let door = [];
      let drawer = [];
      let box = ''
      inputs.each(function () {
        const taxonomy = $(this).data('taxonomy');
        switch (taxonomy) {
          case 'product_cat':
            category = $(this).val();
            break;
          case 'door':
            door = [...door, $(this).val()]
            break
          case 'drawer':
            drawer = [...drawer, $(this).val()]
            break;
          case 'box_material':
            box = $(this).val();
            break
        }
      })


      Cookies.set('product_cat', JSON.stringify(category));
      Cookies.set('door', JSON.stringify(door));
      Cookies.set('box_material', JSON.stringify(box));
      Cookies.set('drawer', JSON.stringify(drawer));


      $.ajax({
        type: 'POST',
        url: ajax_url, // получаем из wp_localize_script()
        data: {
          action: 'check_products_exist_if_filter',
        },
        beforeSend: function () {
          $('.loading').show();
        },
        success: function (data) {
          if (+data) {
            const text = +data > 1 ? `Choose cabinets` : `Choose Cabinet`
            $('#order-form').find('.shop__block:last-child').append(`<a class="button submit" href="/cabinets" id="choose-cabinets">${text}</a>`)
            scroll('choose-cabinets');
          } else {
            $('.sidebar').append(`<span class="sidebar__alert">Sorry, no Cabinets according this criteria</span>`)
          }
        },
        complete() {
          $('.loading').hide();
        }
      });


    } else {
      $('#order-form .submit').removeClass('active');
      Cookies.remove('product_cat');
      Cookies.remove('door');
      Cookies.remove('box_material');
      Cookies.remove('drawer');
    }

    $.ajax({
      type: 'POST',
      url: ajax_url, // получаем из wp_localize_script()
      data: {
        action: 'new_filter',
        next_step: nextStep,
        parent_id,
      },
      beforeSend: function () {
        block.nextAll().remove();
        $('.loading').show();
      },
      success: function (data) {
        if (data.length > 1) {
          block.after(data);
          scroll(nextStep.slug);

          const sidebar = $('.sidebar__attributes');
          sidebar.empty();
          let materials = {};
          inputs.each(function () {
            const val = $(this).val()
            const name = $(this).data('label')
            if (name) materials[name] = val;
          })

          Object.entries(materials).forEach(([key, value]) => {
            sidebar.append(`<div class="sidebar__attribute"><div>${key}:</div><div>${value}</div></div>`)
          })

        } else {
          block.nextAll().remove()
        }
      },
      complete() {
        $('.loading').hide();
      }
    });

  })

  $('body').on('click', '.remove', function () {
    const key = $(this).data('key');

    $.ajax({
      type: 'POST',
      url: ajax_url, // получаем из wp_localize_script()
      data: {
        action: 'delete_item',
        key: key
      },
      beforeSend: function () {
        $('.loading').show();
      },
      success: function (data) {
        $('.product-aside').html(data);
      },
      complete() {
        $('.loading').hide();

      }
    });
  })


  $('.filter-cabinets').on('click', function () {
    const subcategory = $(this).val();
    $.ajax({
      type: 'POST',
      url: ajax_url, // получаем из wp_localize_script()
      data: {
        action: 'filter_cabinets',
        subcategory: subcategory
      },
      beforeSend: function () {
        $('.loading').show();
      },
      success: function (data) {
        $('.product__list').html(data);
      },
      complete() {
        $('.loading').hide();

      }
    });
  })
})

function scroll(id) {
  const el = document.getElementById(id);
  if (el) {
    el.scrollIntoView({behavior: "smooth", inline: "nearest"});
  }
}
