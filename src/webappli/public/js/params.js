function getParam(cle) {
    if (_param_array !== null) {
        param_tab = _param_array;
        // get param
        var prm = param_tab.filter(function (param) {
            return param.cle === cle;
        });
        if (prm.length===0) {
            return null;
        }
        return prm[0].valeur;
    } else {
        return null;
    }
}

