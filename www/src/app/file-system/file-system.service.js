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
var DirectoryPart = (function () {
    function DirectoryPart() {
    }
    return DirectoryPart;
}());
exports.DirectoryPart = DirectoryPart;
var DirectoryInfo = (function () {
    function DirectoryInfo() {
    }
    return DirectoryInfo;
}());
exports.DirectoryInfo = DirectoryInfo;
var ShareLink = (function () {
    function ShareLink() {
    }
    return ShareLink;
}());
exports.ShareLink = ShareLink;
var FileSystemService = (function () {
    function FileSystemService(http) {
        this.http = http;
        // TODO : Mettre la vraie url externe
        this.filesystem_explore_url = 'http://ayx.freeboxos.fr:14789/freebox_os/api.php?service=filesystem&action=explore';
        this.filesystem_play = 'http://ayx.freeboxos.fr:14789/freebox_os/api.php?service=filesystem&action=play';
        this.filesystem_share = 'http://ayx.freeboxos.fr:14789/freebox_os/api.php?service=filesystem&action=share';
        this.filesystem_synopsis = 'http://ayx.freeboxos.fr:14789/freebox_os/api.php?service=filesystem&action=synopsis';
    }
    FileSystemService.prototype.getShareLink = function (path) {
        var headers = new http_1.Headers();
        headers.append('Content-Type', 'application/x-www-form-urlencoded');
        return this.http.post(this.filesystem_share, 'path=' + path, { headers: headers })
            .toPromise()
            .then(function (response) { return response.json().data; })
            .catch(this.handleError);
    };
    FileSystemService.prototype.getDirectoryInfo = function (path) {
        var headers = new http_1.Headers();
        headers.append('Content-Type', 'application/x-www-form-urlencoded');
        return this.http.post(this.filesystem_explore_url, 'path=' + path, { headers: headers })
            .toPromise()
            .then(function (response) { return response.json().data; })
            .catch(this.handleError);
    };
    FileSystemService.prototype.handleError = function (error) {
        console.error('An error occurred', error);
        return Promise.reject(error.message || error);
    };
    FileSystemService = __decorate([
        core_1.Injectable(), 
        __metadata('design:paramtypes', [http_1.Http])
    ], FileSystemService);
    return FileSystemService;
}());
exports.FileSystemService = FileSystemService;
//# sourceMappingURL=file-system.service.js.map