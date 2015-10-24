(function(){
  "use strict";

  function attach_property_events(element){
    element.find('button[name="removeLine"]').on('click', function(event){
      event.target.closest('li').empty();
    });
  }

  $(document).ready(function(){

    $('ul[name="property"] li').each(function(li){
      attach_property_event(li);
    });

    $('button[name="addLine"]').on('click',function(){
      $('ul[name="property"]').append('<!-- INCLUDE ../part/edit_property.html -->');
      attach_property_events($('ul[name="property"] li:last'));
    });

  });
})();
