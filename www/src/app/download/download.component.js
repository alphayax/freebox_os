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
var download_service_1 = require("./download.service");
var DownloadComponent = (function () {
    function DownloadComponent(downloadService) {
        this.downloadService = downloadService;
    }
    DownloadComponent.prototype.getDownloads = function () {
        var _this = this;
        this.downloadService.getDownloads()
            .then(function (downloads) {
            _this.downloads = downloads;
            _this.downloadsSeeding = downloads.filter(function (download) { return download.downloadTask.status === 'seeding'; });
            _this.downloadsDone = downloads.filter(function (download) { return download.downloadTask.status === 'done'; });
            _this.downloadsInProgress = downloads.filter(function (download) { return download.downloadTask.status === 'downloading'; });
        })
            .catch(function (error) { return _this.error = error; });
    };
    DownloadComponent.prototype.cleanDone = function () {
        var _this = this;
        this.downloadService.cleanDone()
            .then(function (downloads) {
            console.log(downloads);
        })
            .catch(function (error) { return _this.error = error; });
    };
    DownloadComponent.prototype.ngOnInit = function () {
        this.getDownloads();
    };
    DownloadComponent = __decorate([
        core_1.Component({
            selector: 'download',
            templateUrl: 'app/download/download.component.html',
            providers: [download_service_1.DownloadService]
        }), 
        __metadata('design:paramtypes', [download_service_1.DownloadService])
    ], DownloadComponent);
    return DownloadComponent;
}());
exports.DownloadComponent = DownloadComponent;
//# sourceMappingURL=download.component.js.map