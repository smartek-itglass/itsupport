// When the browser is ready...
$.validator.addMethod("lettersonly", function(value, element) {
    return this.optional(element) || /^[\sa-z]+$/i.test(value);
},"special character and numeric value not allowed");

/*arraylength: function( value, element, param ) {
	var length = $.isArray( value ) ? value.length : this.getLength($.trim(value), element);
	return this.optional(element) || length >= param;
}*/

$.validator.addMethod('arraylength', function (value, element, param) {
        var length = $.isArray(value) ? value.length : this.getLength($.trim(value), element);
 
        if (element.nodeName.toLowerCase() === 'select' && this.settings.rules[$(element).attr('name')].required !== false) {
            // could be an array for select-multiple or a string, both are fine this way
            return length >= param;
        }
 
        return this.optional(element) || length >= param;
    }, $.format('Please select at least {0} things.'));

$(function() {
  $("#add_category").validate({
      // Specify the validation rules
      rules: 
      {
        category_name: {
            required: true
        },
        category_spanish: {
            required: true
        },
        category_image: {
            required: true
        }
      },
      messages: 
      {
        category_name: {
             required: "Please enter category name",
        },
        category_spanish: {
             required: "Introduzca el nombre de la categoría",
        },
        category_image: {
             required: "Please select image",
        }
      },
      submitHandler: function(form) {
          form.submit();
      }
  });
});
$(function() {
  $("#add_title").validate({
      // Specify the validation rules
      rules: 
      {
        title_name: {
            required: true
        },
        title_spanish: {
            required: true
        },
        category: {
            required: true
        },
      },
      messages: 
      {
        title_name: {
             required: "Please enter title name",
        },
        title_spanish: {
             required: "Introduzca el nombre del título",
        },
        category: {
             required: "Please select category",
        },
      },
      submitHandler: function(form) {
          form.submit();
      }
  });
});
$(function() {
  $("#send_notification").validate({
      // Specify the validation rules
      rules: 
      {
        message: {
            required: true
        },
       
      },
      messages: 
      {
        message: {
             required: "Please enter notification message",
        },
      },
      submitHandler: function(form) {
          form.submit();
      }
  });
});
$(function() {
  $("#add_continent").validate({
      // Specify the validation rules
      rules: 
      {
        continent_name: {
            required: true
        },
        continent_spanish: {
            required: true
        },
      },
      messages: 
      {
        continent_name: {
             required: "Please enter continent",
        },
        continent_spanish: {
             required: "Por favor ingrese el continente",
        },
      },
      submitHandler: function(form) {
          form.submit();
      }
  });
});
$(function() {
  $("#add_country").validate({
      // Specify the validation rules
      rules: 
      {
        continent: {
            required: true
        },
        country_name: {
            required: true
        },
        country_spanish: {
            required: true
        },
        number: {
            required: true
        },
      },
      messages: 
      {
        continent: {
             required: "Please select continent",
        },
        country_name: {
             required: "Please enter country name",
        },
        country_spanish: {
             required: "Introduzca el nombre del país",
        },
        number: {
             required: "Please enter number",
        },
      },
      submitHandler: function(form) {
          form.submit();
      }
  });
});
$(function() {
  $("#add_content").validate({
      // Specify the validation rules
      rules: 
      {
        category: {
            required: true
        },
        title: {
            required: true
        },
        content: {
            required: true
        },
        content_spanish: {
            required: true
        },
      },
      messages: 
      {
        category: {
             required: "Please select category",
        },
        title: {
             required: "Please select Title",
        },
        content: {
             required: "Please enter content",
        },
        content_spanish: {
             required: "Ingrese el contenido",
        },
      },
      submitHandler: function(form) {
          form.submit();
      }
  });
});
$(function() {
  $("#changePassword").validate({
      // Specify the validation rules
      rules: 
      {
         password: {
              required: true
          },
          newPassword: {
              required: true
          },
          RePassword:{
              required: true,
              equalTo : "#newPassword"
          }
      },
      messages: 
      {
          password: {
             required:"Please enter password"
           },  
          newPassword: {
             required:"Please enter new password"
          },
          RePassword: {
              required: "Please conform new password",
              equalTo: "Conform password not match"
          }
      },
      submitHandler: function(form) {
          form.submit();
      }
  });
});
/////////////////////////////////////
$(function() {
  $("#login").validate({
      // Specify the validation rules
      rules: 
      {
          email: {
              required: true,
              email: true
          },
         password: {
              required: true
          }
      },
      messages: 
      {
         email: {
             required:"Please enter email",
             email: "Please enter a valid email address"
          },
         password: {
              required: "Please enter password"
          }
      },
      submitHandler: function(form) {
          form.submit();
      }
  });
});
