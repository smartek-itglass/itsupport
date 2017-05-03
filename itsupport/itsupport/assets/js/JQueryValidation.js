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

$(function() {
  $("#countryAdd").validate({
      // Specify the validation rules
      rules: 
      {
        country_name: {
            required: true
        }
      },
      messages: 
      {
        country_name: {
             required: "Please enter country name",
         }
      },
      submitHandler: function(form) {
          form.submit();
      }
  });
});

$(function() {
  $("#stateAdd").validate({
      // Specify the validation rules
      rules: 
      {
        country_id: {
            required: true
        },
        state_name: {
            required: true
        }
      },
      messages: 
      {
        country_id: {
             required: "Please select country",
        },
        state_name: {
             required: "Please enter state",
         }
      },
      submitHandler: function(form) {
          form.submit();
      }
  });
});

$(function() {
  $("#cityAdd").validate({
      // Specify the validation rules
      rules: 
      {
      	country_id: {
            required: true
        },
        state_id: {
            required: true
        },
        city_name: {
            required: true
        }
      },
      messages: 
      {
      	country_id: {
             required: "Please select country",
        },
        state_id: {
             required: "Please select state",
        },
        city_name: {
             required: "Please enter city",
         }
      },
      submitHandler: function(form) {
          form.submit();
      }
  });
});

$(function() {
  $("#areaAdd").validate({
      // Specify the validation rules
      rules: 
      {
      	country_id: {
            required: true
        },
        state_id: {
            required: true
        },
        city_id: {
            required: true
        },
        area_name: {
            required: true
        }
      },
      messages: 
      {
      	country_id: {
             required: "Please select country",
        },
        state_id: {
             required: "Please select state",
        },
        city_id: {
             required: "Please select city",
        },
        area_name: {
             required: "Please enter area",
         }
      },
      submitHandler: function(form) {
          form.submit();
      }
  });
});

$(function() {
  $("#foodTypeAdd").validate({
      // Specify the validation rules
      rules: 
      {
        food_cat_name: {
            required: true
        }
      },
      messages: 
      {
        food_cat_name: {
             required: "Please enter food type",
         }
      },
      submitHandler: function(form) {
          form.submit();
      }
  });
});

$(function() {
  $("#addRestaurant").validate({
      // Specify the validation rules
      rules: 
      {
         
          email: {
              required: true,
              email: true
          },
          paypal_email: {
              required: true,
              email: true
          },
          restaurant_img: {
              required: true
          },
          restaurant_name: {
              required: true,
              lettersonly : true
          },
          user_name: {
              required: true,
              lettersonly : true
          },
          contact:{
              required:true,
              number:true,
              maxlength:10,
              minlength:10
          },
          start_day: {
              required: true
          },
          close_day: {
              required: true
          },
          open_time: {
              required: true
          },
          close_time: {
              required: true
          },
          min_amount: {
          	  number: true,
              required: true
          },
          tax: {
          	  number: true,
              required: true
          },
          /*avail_distance: {
          	  number: true,
              required: true
          },*/
          delivery_time: {
          	  number: true,
              required: true
          },
          retry_time_limit: {
          	  number: true,
              required: true
          },
          description: {
              required: true,
              maxlength:400
          },
          /*'food_cat_id[]': {
              required: true
              //minlength:1
              /*required: function(elem)
              {
               return $('input[name="checkboxes[]"]:checked').length > 0;

              }
          },*/
          country_id: {
              required: true
          },
          state_id:{
              required: true
          },
          city_id: {
              required: true
          },
          address: {
              required: true,
              maxlength:200
          },
          select2_sample2:{
              //arraylength: 1
          }
      },
      messages: 
      {
          
          email: {
             required:"Please enter email id",
             email: "Please enter a valid email address"
          },
          paypal_email: {
             required:"Please enter paypal email id",
             email: "Please enter a valid email address"
          },
          restaurant_img: {
             required:"Select image"
          },
          restaurant_name: {
             required:"Please enter restaurant name",
             lettersonly : "Invalid name"
             
           },  
           user_name: {
             required:"Please enter owner name",
             lettersonly : "Invalid name"
             
           },  
          contact:{
              required: "Please enter contact number ",
              number:"Invalid no",
              minlength: "Your mobile no. must be at least 10 Number",
              maxlength: "Max. length should be 10 only"
          },
          
          start_day: {
             required:"Select day"
          },
          close_day: {
             required:"Select day"
          },
          open_time: {
             required:"Select open time"
          },
          close_time: {
             required:"Select close time"
          },
          min_amount: {
              number:"Charges must be in numbers",
              required:"Please enter min amount"
          },
          tax: {
              number:"Value must be in numbers",
              required:"Please enter tax"
          },
          /*avail_distance: {
              number:"Value must be in numbers",
              required:"Please enter distance"
          },*/
          delivery_time: {
              number:"Value must be in numbers",
              required:"Please enter time"
          },
          retry_time_limit: {
              number:"Value must be in numbers",
              required:"Please enter time limit"
          },
          description: {
              required: "Please enter description",
              maxlength: "Max. character should be 400 only"
          },
          /*'food_cat_id[]': {
              required: "Please select type"
              //checked : "Checked"
          },*/
          country_id: {
             required:"Please select country"
          },
          state_id: {
              required: "Please select state"
          },
          city_id: {
             required:"Please select city"
          },
          address: {
              required: "Please enter address",
              maxlength: "Max. character should be 200 only"
          },
          select2_sample2: {
              //arraylength: $.format('Please select at least 1 things.')
          }
      },
      submitHandler: function(form) {
          form.submit();
      }
  });
});

$(function() {
  $("#couponMaster").validate({
      // Specify the validation rules
      rules: 
      {
        coupon_code: {
            required: true
        },
        reffer_user_count: {
            number : true
        },
        discount: {
            required: true,
            number : true
        },
        validity_start_date: {
            required: true
        },
        validity_end_date: {
            required: true
        }
      },
      messages: 
      {
        coupon_code: {
             required: "Please generate code"
        },
        reffer_user_count: {
             number :  "Value must be in numbers"
        },
        discount: {
             required: "Please enter discount",
             number :  "Discount must be in numbers"
        },
        validity_start_date: {
             required: "Please select start date"
        },
        validity_end_date: {
             required: "Please select end date"
        }
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

$(function() {
  $("#menuAdd").validate({
      // Specify the validation rules
      rules: 
      {
        menu_title: {
            required: true
        }
      },
      messages: 
      {
        menu_title: {
             required: "Please enter menu",
         }
      },
      submitHandler: function(form) {
          form.submit();
      }
  });
});

$(function() {
  $("#foodItem").validate({
      // Specify the validation rules
      rules: 
      {
        rest_menu_id: {
            required: true
        },
        item_name: {
            required: true
        },
        /*item_img: {
            required: true
        },*/
        item_description: {
            required: true
        },
        item_price: {
            required: true,
            number:true
        }
      },
      messages: 
      {
        rest_menu_id: {
             required: "Please select menu"
        },
        item_name: {
             required: "Please enter item name"
        },
        /*item_img: {
             required: "Please select image"
        },*/
        item_description: {
             required: "Please enter item description"
        },
        item_price: {
             required: "Please enter item price",
             number:"Price must be in numbers"
        }
      },
      submitHandler: function(form) {
          form.submit();
      }
  });
});

$(function() {
  $("#chargesMaster").validate({
      // Specify the validation rules
      rules: 
      {
        min_price: {
            required: true,
            number : true
        },
        max_price: {
            required: true,
            number : true
        },
        restaurant_per: {
            required: true,
            number : true
        },
        restaurant_amount: {
            required: true,
            number : true
        },
        del_weekday_per: {
            required: true,
            number : true
        },
        del_weekday_amount: {
            required: true,
            number : true
        },
        del_weekend_per: {
            required: true,
            number : true
        },
        del_weekend_amount: {
            required: true,
            number : true
        }
      },
      messages: 
      {
        min_price: {
             required: "Please enter min price",
             number :  "Value must be in numbers"
        },
        max_price: {
             required: "Please enter max price",
             number :  "Value must be in numbers"
        },
        restaurant_per: {
             required: "Please enter restaurant %",
             number :  "Value must be in numbers"
        },
        restaurant_amount: {
             required: "Please enter restaurant amount",
             number :  "Value must be in numbers"
        },
        del_weekday_per: {
             required: "Please enter weekdays %",
             number :  "Value must be in numbers"
        },
        del_weekday_amount: {
             required: "Please enter weekdays amount",
             number :  "Value must be in numbers"
        },
        del_weekend_per: {
             required: "Please enter weekend %",
             number :  "Value must be in numbers"
        },
        del_weekend_amount: {
             required: "Please enter weekend amount",
             number :  "Value must be in numbers"
        }
      },
      submitHandler: function(form) {
          form.submit();
      }
  });
});


$(function() {
  $("#preparationTime").validate({
      // Specify the validation rules
      rules: 
      {
        est_time: {
            required: true
        }
      },
      messages: 
      {
        est_time: {
             required: "Please select time",
         }
      },
      submitHandler: function(form) {
          form.submit();
      }
  });
});