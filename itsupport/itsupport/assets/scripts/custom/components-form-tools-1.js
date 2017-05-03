var ComponentsFormTools = function () {


    var handleBootstrapTouchSpin = function() {

        $("#touchspin_demo1,#touchspin_demo2").TouchSpin({
            buttondown_class: 'btn blue',
            buttonup_class: 'btn blue',
            min: 0,
            max: 500,
            step: 0.1,
            decimals: 2,
            boostat: 5,
            maxboostedstep: 10,
            postfix: 'INR'
        });
        /*$("#touchspin_demo2").TouchSpin({
            buttondown_class: 'btn blue',
            buttonup_class: 'btn blue',
            min: 0,
            max: 500,
            step: 0.1,
            decimals: 2,
            boostat: 5,
            maxboostedstep: 10,
            postfix: ''
        });  */
        $("#touchspin_demo3").TouchSpin({
            buttondown_class: 'btn blue',
            buttonup_class: 'btn blue',
            min: 0,
            max: 100,
            step: 0.1,
            decimals: 2,
            boostat: 5,
            maxboostedstep: 10,
            postfix: '%'
        });    

    }

    return {
        //main function to initiate the module
        init: function () {
            handleBootstrapTouchSpin();
        }
    };

}();