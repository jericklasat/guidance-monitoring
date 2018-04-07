/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 51);
/******/ })
/************************************************************************/
/******/ ({

/***/ 51:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(52);


/***/ }),

/***/ 52:
/***/ (function(module, exports) {

/**
 * HTTP Manager
 * This file handle all ajax api request
 *
 */
var indent = [];
HTTP_MANAGER = typeof HTTP_MANAGER !== 'undefined' ? HTTP_MANAGER : {};
HTTP_MANAGER = function () {

    var _handleLoading = function _handleLoading(callback, identifier) {
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

    var __executeGet = function __executeGet(url, callback, identifier) {
        _handleLoading(callback, identifier);
        var dfd = $.Deferred();

        axios.get($('meta[name=base-url]').attr("content") + '/api' + url).then(function (response) {
            dfd.resolve(response);
        }).catch(function (error) {
            dfd.resolve({
                status: 'ERROR',
                message: error
            });
        });

        return dfd.promise();
    };

    var __executePost = function __executePost(url, data, callback, identifier) {
        _handleLoading(callback, identifier);
        var dfd = $.Deferred();

        axios.post($('meta[name=base-url]').attr("content") + '/api' + url, data).then(function (response) {
            dfd.resolve(response);
        }).catch(function (error) {
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
    };
}();

/***/ })

/******/ });