Tc.$(document).ajaxError(function(e, xhr, settings, exception) {
    alert('error in: ' + settings.url + ' \n'+'error:\n' + xhr.responseText );
}); 