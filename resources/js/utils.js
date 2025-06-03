export function exportToExcel(tableId, fileName = 'exportacion') {

   var uri = 'data:application/vnd.ms-excel;base64,'
        , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>'
        , base64 = function (s) { return window.btoa(unescape(encodeURIComponent(s))); }
        , format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }); };

    if (typeof tableId === 'string') {
        tableId = document.getElementById(tableId);
    }


    if (!tableId) {
        console.error("El elemento de la tabla con ID proporcionado no fue encontrado.");
        return;
    }

    if (!fileName.endsWith('.xls') && !fileName.endsWith('.xlsx')) {
        fileName += '.xls';
    }

    var ctx = { worksheet: fileName.replace(/\.xls(x)?$/, '') || 'Worksheet', table: tableId.innerHTML };

    var a = document.createElement('a');
    a.href = uri + base64(format(template, ctx));
    a.download = fileName;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}
