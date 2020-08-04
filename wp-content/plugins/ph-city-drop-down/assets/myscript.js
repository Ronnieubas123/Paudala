function addState(state_and_cities, selectState, selectCity) {

    select_state = {
        0 :selectState,
    };

    select_city = {
        0: selectCity,
    };

    var stateOptions = [];
    //make array of states
    for (var i = 1; i < state_and_cities[0].length; i++) {
        stateOptions.push(state_and_cities[0][i]);
    }

    //populate null(--select--)and states and append in options
    var el = jQuery("#billing_state");
    el.empty(); // remove old options
    jQuery.each(select_state,  function(key,value){
        el.append(jQuery("<option></option>")
            .attr("value", key).text(value));
    });
    jQuery.each(state_and_cities[0], function(key,value) {
        el.append(jQuery("<option></option>")
            .attr("value", key).text(value));
    });

    var sl = jQuery("#shipping_state");
    sl.empty(); // remove old options
    jQuery.each(select_state,  function(key,value){
        sl.append(jQuery("<option></option>")
            .attr("value", key).text(value));
    });
    jQuery.each(state_and_cities[0], function(key,value) {
        sl.append(jQuery("<option></option>")
            .attr("value", key).text(value));
    });

    //make array of cities
    var cityOptions = [];
    for (var i = 0; i < state_and_cities[1].length; i++) {
        cityOptions.push(state_and_cities[1][i]);
    }

    //populate null(--select--)and cities and append in options
    var el = jQuery("#billing_city");
    el.empty(); // remove old options
    jQuery.each(select_city,  function(key,value){
        el.append(jQuery("<option></option>")
            .attr("value", value).text(value));
    });
    jQuery.each(cityOptions, function(key,value) {
        el.append(jQuery("<option></option>")
            .attr("value", value).text(value));
    });

    var sl = jQuery("#shipping_city");
    sl.empty(); // remove old options
    jQuery.each(select_city,  function(key,value){
        sl.append(jQuery("<option></option>")
            .attr("value", value).text(value));
    });
    jQuery.each(cityOptions, function(key,value) {
        sl.append(jQuery("<option></option>")
            .attr("value", value).text(value));
    });
    
    // Change style of Select City Field
    jQuery('#billing_city').select2();
    jQuery('#billing_city_field').find('.select2-container').css("width","100%");

    jQuery('#shipping_city').select2();
    jQuery('#shipping_city_field').find('.select2-container').css("width","100%");
    
    //check state selected and update city
    jQuery("#billing_state").change(function(){

        var selectedState = jQuery(this).children("option:selected").val();
        var index=1;
        
        i = 1;

        jQuery.each(state_and_cities[0],  function(key,value){
            if(key==selectedState)
            {
                index=i;
                return true;
            }
            i++;
        });

        cityOptions = [];
        for (var i = 0; i < state_and_cities[index].length; i++) {
            cityOptions.push(state_and_cities[index][i]);
        }

        var el = jQuery("#billing_city");
        el.empty(); // remove old options
        jQuery.each(select_city,  function(key,value){
            el.append(jQuery("<option></option>")
                .attr("value", value).text(value));
        });

        jQuery.each(cityOptions, function(key,value) {
            el.append(jQuery("<option></option>")
                .attr("value", value).text(value));
        });

    });

    jQuery("#shipping_state").change(function(){

        var selectedState = jQuery(this).children("option:selected").val();
        var index=1;
        
        i = 1;

        jQuery.each(state_and_cities[0],  function(key,value){
            if(key==selectedState)
            {
                index=i;
                return true;
            }
            i++;
        });

        cityOptions = [];
        for (var i = 0; i < state_and_cities[index].length; i++) {
            cityOptions.push(state_and_cities[index][i]);
        }

        var sl = jQuery("#shipping_city");
        sl.empty(); // remove old options
        jQuery.each(select_city,  function(key,value){
            sl.append(jQuery("<option></option>")
                .attr("value", value).text(value));
        });

        jQuery.each(cityOptions, function(key,value) {
            sl.append(jQuery("<option></option>")
                .attr("value", value).text(value));
        });

    });

    //re-populate state on change of country
    jQuery("#billing_country").change(function(){
        stateOptions = [];
        for (var i = 1; i < state_and_cities[0].length; i++) {
            stateOptions.push(state_and_cities[0][i]);
        }

        var el = jQuery("#billing_state");
        el.empty(); // remove old options
        jQuery.each(select_state,  function(key,value){
            el.append(jQuery("<option></option>")
                .attr("value", key).text(value));
        });
        jQuery.each(state_and_cities[0], function(key,value) {
            el.append(jQuery("<option></option>")
                .attr("value", key).text(value));
        });
    });

    jQuery("#shipping_country").change(function(){
        stateOptions = [];
        for (var i = 1; i < state_and_cities[0].length; i++) {
            stateOptions.push(state_and_cities[0][i]);
        }

        var sl = jQuery("#shipping_state");
        sl.empty(); // remove old options
        jQuery.each(select_state,  function(key,value){
            sl.append(jQuery("<option></option>")
                .attr("value", key).text(value));
        });
        jQuery.each(state_and_cities[0], function(key,value) {
            sl.append(jQuery("<option></option>")
                .attr("value", key).text(value));
        });
    });
}

window.onload = function() {

    state_and_cities  = ph_city_drop_down_admin.state_and_cities;
    selectState       = ph_city_drop_down_admin.selectState;
    selectCity        = ph_city_drop_down_admin.selectCity;

    if( state_and_cities != "" )
    {
        addState(state_and_cities, selectState, selectCity);
    }
};