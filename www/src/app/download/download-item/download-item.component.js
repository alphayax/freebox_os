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
var download_item_1 = require("../download-item");
var download_item_service_1 = require("./download-item.service");
var router_1 = require("@angular/router");
var DownloadItemComponent = (function () {
    function DownloadItemComponent(downloadItemService, router) {
        this.downloadItemService = downloadItemService;
        this.router = router;
    }
    DownloadItemComponent.prototype.clearDownload = function () {
        var _this = this;
        this.downloadItemService.cleanFromId(this.downloadItem.downloadTask.id)
            .then(function (downloads) {
            console.log(downloads);
        })
            .catch(function (error) { return _this.error = error; });
    };
    DownloadItemComponent.prototype.pauseDownload = function () {
        var _this = this;
        this.downloadItemService.updateFromId(this.downloadItem.downloadTask.id, 'pause')
            .then(function (download) {
            _this.downloadItem = download;
        })
            .catch(function (error) { return _this.error = error; });
    };
    DownloadItemComponent.prototype.resumeDownload = function () {
        var _this = this;
        this.downloadItemService.updateFromId(this.downloadItem.downloadTask.id, 'download')
            .then(function (download) {
            _this.downloadItem = download;
        })
            .catch(function (error) { return _this.error = error; });
    };
    DownloadItemComponent.prototype.getRxPct = function () {
        return this.downloadItem.downloadTask.rx_pct / 100;
    };
    DownloadItemComponent.prototype.getTxPct = function () {
        return this.downloadItem.downloadTask.tx_pct / 100;
    };
    DownloadItemComponent.prototype.getCleanName = function () {
        return this.downloadItem.name;
    };
    DownloadItemComponent.prototype.getImage = function () {
        return this.downloadItem.image;
    };
    DownloadItemComponent.prototype.navigate = function () {
        this.router.navigate(['/file-system', btoa(this.downloadItem.path)]);
    };
    DownloadItemComponent.prototype.isStoppable = function () {
        return this.downloadItem.downloadTask.status !== 'stopped' && this.downloadItem.downloadTask.status !== 'error';
    };
    DownloadItemComponent.prototype.isResumable = function () {
        return this.downloadItem.downloadTask.status === 'stopped';
    };
    __decorate([
        core_1.Input(), 
        __metadata('design:type', download_item_1.DownloadItem)
    ], DownloadItemComponent.prototype, "downloadItem", void 0);
    DownloadItemComponent = __decorate([
        core_1.Component({
            selector: 'download-item',
            templateUrl: 'app/download/download-item/download-item.component.html',
            providers: [download_item_service_1.DownloadItemService]
        }), 
        __metadata('design:paramtypes', [download_item_service_1.DownloadItemService, router_1.Router])
    ], DownloadItemComponent);
    return DownloadItemComponent;
}());
exports.DownloadItemComponent = DownloadItemComponent;
//# sourceMappingURL=download-item.component.js.map