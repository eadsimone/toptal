function uniquify() {
    return "?v=" + new Date().getTime();
}

function addThisShare(socialSystem, playerGuid, servicebusUrl) {

    var servicesEndpointUrl = "http://api.addthis.com/oexchange/0.8/forward/"+socialSystem+"/offer?";

    if ( socialSystem == 'facebook' || socialSystem == 'myspace' || socialSystem ==  'mymailru') {
        servicesEndpointUrl = servicesEndpointUrl + "&url=" + encodeURIComponent(servicebusUrl + "/social/share/fb/" + playerGuid + uniquify()) + "&username=cinsayinc";
    }
    else if ( socialSystem == 'twitter' ) {
        servicesEndpointUrl = servicesEndpointUrl + "&url=" + encodeURIComponent(servicebusUrl + "/social/share/" + playerGuid + uniquify()) + "&via=Cinsay&text=check%20out";
    }
    else {
        servicesEndpointUrl = servicesEndpointUrl + "&url=" + encodeURIComponent(servicebusUrl + "/social/share/" + playerGuid + uniquify());
    }
    servicesEndpointUrl = servicesEndpointUrl + "&pubid=" + "ra-4f78ccfe2ddf2958";

    window.open(servicesEndpointUrl,'_blank');
}
