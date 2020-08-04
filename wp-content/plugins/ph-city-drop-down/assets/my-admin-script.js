
jQuery(window).load(function(){
    jQuery('#state_and_cities_table .insert').click( function() {
        var count = 0;
        for( var state in states) {
            count++;
        }

        if(count > 0){
            var tbody = jQuery('#state_and_cities_table').find('tbody');
            var size = tbody.find('tr').length;
            var code = '<tr>\
                            <td class="check-column" style="padding: 9px; vertical-align: middle;">\
                                <input type="checkbox" />\
                            </td>\
                            <td>\
                                <select name="shipment_state['+ size +'] ">\
                                <option disabled selected value> Select State </option>';
                for(var key in states){
                    var code2 = '<option value="'+key+'">'+states[key]+'</option>';
                    code += code2;
                }
                var code3 = '</select>\
                            </td>';
                code +=code3;
            var code4 = '<td>\
                            <input type="text" placeholder="Eg: London, New york city   " name="shipment_cities['+ size +']" value=""/>\
                        </td>\
                    </tr>';
            code += code4;
            tbody.append( code );
            return false;
        }
        else {
            var tbody = jQuery('#state_and_cities_table').find('tbody');
            var size = tbody.find('tr').length;
            var code = '<tr>\
                            <td class="check-column" style="padding: 9px; vertical-align: middle;">\
                                <input type="checkbox" />\
                            </td>\
                        <td>\
                            <input type="text" size="50" placeholder="Eg: California" size="50" name="shipment_state[' + size + ']" value=""/>\
                        </td>\
                            <td>\
                                <input type="text" placeholder="Eg: London, New york city   " name="shipment_cities['+ size +']" value=""/>\
                            </td>\
                        </tr>';
            tbody.append( code );
            return false;
        }
        
    } );

    jQuery('#state_and_cities_table .remove').click(function() {
            var tbody = jQuery('#state_and_cities_table').find('tbody');
            tbody.find('.check-column input:checked').each(function() {
                    jQuery(this).closest('tr').hide().find('input').val('');
                    jQuery(this).closest('tr').hide().find('select').val('');

            });
            return false;
    });
    jQuery(window).load(function(){
        var tbody = jQuery('#state_and_cities_table').find('tbody');
        var size = tbody.find('tr').length;
        if(size<1)
        {

        }
    });
});