/**
 * HTTP Manager
 * This file handle all ajax api request
 *
 */
var indent = [];
HTTP_MANAGER = (typeof HTTP_MANAGER !== 'undefined') ? HTTP_MANAGER : {};
HTTP_MANAGER = (function () {

    var _handleLoading = function (callback,identifier) {
        var res_indi = 0;
        axios.interceptors.request.use(function (config) {
            // Do something before request is sent
            if (res_indi === 0) {
                if (indent.indexOf(identifier) > -1) {
                    if (callback !== undefined) {
                        callback();
                    }
                } else {
                    if (identifier !== undefined) {
                        indent.push(identifier);
                    }
                }
            }
            res_indi++;
            return config;
        }, function (error) {
            // Do something with request error
            return Promise.reject(error);
        });
    };

    var __executeGet = function (url,callback,identifier) {
        _handleLoading(callback,identifier);
        var dfd = $.Deferred();

        axios.get( $('meta[name=base-url]').attr("content")+'/api' + url)
            .then(function (response) {
                dfd.resolve(response);
            })
            .catch(function (error) {
                dfd.resolve({
                    status: 'ERROR',
                    message: error
                });
            });

        return dfd.promise();
    };

    var __executePost = function (url, data, callback,identifier) {
        _handleLoading(callback,identifier);
        var dfd = $.Deferred();

        axios.post( $('meta[name=base-url]').attr("content")+'/api' + url, data)
            .then(function (response) {
                dfd.resolve(response);
            })
            .catch(function (error) {
                dfd.resolve({
                    status: 'ERROR',
                    message: error
                });
            });

        return dfd.promise();
    };

    return {
        executeGet: __executeGet,
        executePost: __executePost
    }
}());