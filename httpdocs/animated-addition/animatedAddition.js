

/**
 animatedAddition - JQuery plugin for animating the rolling up or down of a number
 numTarget Number - The eventual number that we want to display
 @strPrepend String or Array - Describes what to prepend. If array, the first is the plural version the second is the singular and the third is in the case of zero value
 @strAppend String or Array - Describes what to append. If array, the first is the plural version the second is the singular and the third is in the case of zero value
 @uniqueKey String - A key to attatch to the data attribute, this stops 2 conflicting calls on the same element constanctly fighting, 1 going up, 1 going down
*/
(function( $ ){
	$.fn.animatedAddition = function( numTarget, prepend, append, uniqueKey ){

		var arrPrepend = [];
		arrPrepend[0] = ''; // plural
		arrPrepend[1] = ''; // singular
		arrPrepend[2] = ''; // zero
		var arrAppend = [];
		arrAppend[0] = '';
		arrAppend[1] = '';
		arrAppend[2] = '';

		if( typeof prepend === 'string' ){
			arrPrepend[0] = arrPrepend[1] = arrPrepend[2] = prepend;
		} else if( typeof prepend === 'object' ){
			arrPrepend[0] = prepend[0];
			if( prepend.length > 1 ){
				arrPrepend[1] = prepend[1];
			}
			if( prepend.length > 2 ){
				arrPrepend[2] = prepend[2];
			}
		}

		if( typeof append === 'string' ){
			arrAppend[0] = arrAppend[1] = arrAppend[2] = append;
		} else if( typeof append === 'object' ){
			arrAppend[0] = append[0];
			if( append.length > 1 ){
				arrAppend[1] = append[1];
			}
			if( append.length > 2 ){
				arrAppend[2] = append[2];
			}
		}

		var currentValue = 0;

		if( typeof uniqueKey === 'undefined' ){

			// Get the current value from non-uniqified current value
			currentValue = $(this).data('currentvalue');

			uniqueKey = "";
		    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
		    for( var i=0; i < 5; i++ ){
		        uniqueKey += possible.charAt(Math.floor(Math.random() * possible.length));
		    }

		    currentValueDataAttribute = 'currentvalue' + uniqueKey;

		} else {

			// Get the current value from the uniqified current value
			currentValueDataAttribute = 'currentvalue' + uniqueKey;
		
			// Get the current value
			currentValue = $(this).data(currentValueDataAttribute);
			if( typeof currentValue === 'undefined' || !$.isNumeric(currentValue) ) {
				currentValue = 0;
			} 

		}

		// Calculate difference 
		var diff = numTarget - currentValue;


		// Establish Step Size
		var numStepSize = Math.round(diff / 3);


		if( diff < 0 && numStepSize > -1 ){
			numStepSize = -1;
		}

		if( diff > 0 && numStepSize < 1 ){
			numStepSize = 1;
		}


		var newCurrent = currentValue + numStepSize;
		var affixKey = 0; // Plural
		if( newCurrent === 1 ){
			affixKey = 1; // Singular
		} else if( newCurrent === 0 ){
			affixKey = 2; // Zero
		}

		// Update the DOM
		var formattedCurrent = grandFormat(newCurrent);
		$(this).data(currentValueDataAttribute,newCurrent).html( arrPrepend[affixKey] + formattedCurrent + arrAppend[affixKey] );

		
		// If there is still something to do, call the function again
		if( newCurrent !== numTarget ){
			setTimeout( "$('#" + $(this).attr('id') + "').animatedAddition( " + numTarget + ", " + JSON.stringify(arrPrepend) + ", " + JSON.stringify(arrAppend) + ", '" + uniqueKey + "');", 40 );
		} else {
			// Set the non uniqified current value
			$(this).data('currentvalue', newCurrent);
		}

	};
}( jQuery )); 

// Takes a number, trims to 2 dp and adds a comma after the first 1-3 numbers
function grandFormat( val ) {
	return val.toString().replace(/([0-9]{1,3})([0-9]{3}(\.|$)+)/i, '$1,$2');
}	
