

// nakładka na jquery ajax
function ax(o, url, callback, type = "POST") {

    callback = $.isFunction(callback) ? callback : false;

    o = JSON.stringify(o);

    let jqXHR = $.ajax({
        url: window.location.origin + url,
        type: type,
        dataType: 'json',
        data: {json: o}
    });

    jqXHR.done(function (data) {
        if (callback) callback(data);
    });

    jqXHR.fail(function (data) {
        console.log('ajax fail');
    });
}

//Lodash is a modern JavaScript utility library that can perform many JavaScript functionalities with very basic syntax.
const isObjectEmpty = (objectName) => {
    return _.isEmpty(objectName);
};






export { ax, isObjectEmpty }


// ---------------------      testy
// function smallText(txt) {
//     return txt.toLowerCase();
// }
//
// function bigText(txt) {
//     return txt.toUpperCase();
// }
//
// function mixText(txt) {
//     return [...txt].map((el, i) => i%2 === 0 ? el.toLowerCase() : el.toUpperCase());
// }

//export { smallText, bigText, mixText }
