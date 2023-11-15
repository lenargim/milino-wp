$(document).ready(function () {
  const ajax_url = window.ajaxVar.ajaxurl || false;
  const steps = [
    {
      slug: 'room',
      type: 'category',
      name: 'Room'
    },
    {
      slug: 'door-type',
      type: 'category',
      name: 'Door Type'
    },
    {
      slug: 'finish-material',
      type: 'attribute',
      name: 'Finish Material',
    },
    {
      slug: 'finish-color',
      type: 'attribute',
      name: 'Finish Color',
    },
    {
      slug: 'box-material',
      type: 'attribute',
      name: 'Box Material',
    },
    {
      slug: 'drawer-brand',
      type: 'attribute',
      name: 'Drawer Brand',
      noFilter: true,
    },
    {
      slug: 'drawer-type',
      type: 'attribute',
      name: 'Drawer Type',
      noFilter: true,
    },
    {
      slug: 'drawer-color',
      type: 'attribute',
      name: 'Drawer Color',
    },
  ];
  $('#order-form').on('change', '.show__row-input', function () {
    const parentId = +$(this).data('id');
    const block = $(this).parents('.shop__row');
    block.nextAll().remove();


    const currentStep = block.attr('id');
    const current = steps.find(step => step.slug === currentStep);
    const nextStepIndex = steps.indexOf(current) + 1
    const nextStep = steps[nextStepIndex];
    const inputs = $('#order-form :input:checked');

    let category;
    let attributes = {};
    inputs.each(function () {
      switch ($(this).data('type')) {
        case 'category':
          category = $(this).val();
          break
        case 'attribute':
          const key = $(this).parents('.shop__row').attr('id');
          if (key) attributes[key] = $(this).val();
      }
    })
    if (inputs.length === steps.length) {
      $('#order-form .submit').addClass('active')
      Cookies.set('attributes', JSON.stringify(attributes));
      Cookies.set('category', JSON.stringify(category));

    } else {
      $('#order-form .submit').removeClass('active');
      Cookies.remove('attributes');
    }


    $.ajax({
      type: 'POST',
      url: ajax_url, // получаем из wp_localize_script()
      data: {
        action: 'new_filter',
        next_step: nextStep,
        parent_id: parentId,
        category: category,
        attributes: attributes,
      },
      beforeSend: function () {
        block.nextAll().remove();
        $('body').prepend('<div class="loading"><div class="loading-box"><div class="circle"></div></div>');
      },
      success: function (data) {
        if (data.length > 1) {
          block.after(data);
          scroll(nextStep.slug);
        } else {
          block.nextAll().remove()
        }
      },
      complete() {
        $('.loading').remove();
        updateSidebar(ajax_url);

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
        $('body').prepend('<div class="loading"><div class="loading-box"><div class="circle"></div></div>');
      },
      success: function (data) {
        $('.product-aside').html(data);
      },
      complete() {
        $('.loading').remove();

      }
    });
  })
})

function scroll(id) {
  const el = document.getElementById(id);
  if (el) {
    el.scrollIntoView({ behavior: "smooth", inline: "nearest" });
  }
}

function updateSidebar(ajax_url) {
  const block = $('.sidebar__attributes');
  let category;
  let attributes = {};
  const inputs = $('#order-form :input:checked');
  inputs.each(function () {
    switch ($(this).data('type')) {
      case 'category':
        category = $(this).val();
        break
      case 'attribute':
        const key = $(this).parents('.shop__row').attr('id');
        if (key) attributes[key] = $(this).val();
    }
  })

  $.ajax({
    type: 'POST',
    url: ajax_url,
    data: {
      action: 'update_sidebar',
      attributes: attributes,
    },
    beforeSend: function () {
      block.empty();
    },
    success: function (data) {
      if (data.length) {
        data.forEach(el => {
          block.append(`<div class="sidebar__attribute">
<div>${Object.keys(el)}:</div>
<div>${Object.values(el)}</div> 
</div>`)
        })
      }
    },
  })
}