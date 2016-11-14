/**
 * Created by Sam on 06/11/2016.
 */

var MyApp = angular.module('MyApp', []);


function buttonLoad(button, running)
{
	if (running == true)
	{
		button.attr('data-loading-text', '<i class="fa fa-spinner fa-spin"></i> ' + button.text());
		button.button('loading');
	} else
	{
		button.button('reset');
	}
}