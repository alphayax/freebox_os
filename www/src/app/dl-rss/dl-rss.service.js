"use strict";
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var core_1 = require('@angular/core');
var http_1 = require("@angular/http");
require('rxjs/add/operator/toPromise');
var DlRssService = (function () {
    function DlRssService(http) {
        this.http = http;
        // Todo : Mettre l'url a jour
        this.action_getList = 'http://ayx.freeboxos.fr:14789/freebox_os/api.php?service=download_dlrss&action=get_list';
        this.action_checkFromId = 'http://ayx.freeboxos.fr:14789/freebox_os/api.php?service=download_dlrss&action=check_from_id';
    }
    DlRssService.prototype.checkRss = function (downloadId) {
        var headers = new http_1.Headers();
        headers.append('Content-Type', 'application/json');
        var params = JSON.stringify({
            'id': downloadId
        });
        return this.http.post(this.action_checkFromId, params, headers)
            .toPromise()
            .then(function (response) { return response.json().data; })
            .catch(DlRssService.handleError);
    };
    DlRssService.prototype.getPatterns = function () {
        var headers = new http_1.Headers();
        headers.append('Content-Type', 'application/json');
        return this.http.post(this.action_getList, '', headers)
            .toPromise()
            .then(function (response) { return response.json().data; })
            .catch(DlRssService.handleError);
    };
    DlRssService.handleError = function (error) {
        console.error('An error occurred', error);
        return Promise.reject(error.message || error);
    };
    DlRssService = __decorate([
        core_1.Injectable(), 
        __metadata('design:paramtypes', [http_1.Http])
    ], DlRssService);
    return DlRssService;
}());
exports.DlRssService = DlRssService;
//# sourceMappingURL=dl-rss.service.js.map