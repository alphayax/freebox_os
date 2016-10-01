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
var file_info_1 = require("../file-info");
var file_system_service_1 = require("../file-system.service");
var router_1 = require("@angular/router");
var FileInfoComponent = (function () {
    function FileInfoComponent(router, fileSystemService) {
        this.router = router;
        this.fileSystemService = fileSystemService;
    }
    FileInfoComponent.prototype.navigate = function (path) {
        this.router.navigate(['/file-system', btoa(path)]);
    };
    FileInfoComponent.prototype.isStreamable = function () {
        return (this.fileInfo.fileInfo.mimetype === 'video/ogg' ||
            this.fileInfo.fileInfo.mimetype === 'video/mp4' ||
            this.fileInfo.fileInfo.mimetype === 'video/webm');
    };
    FileInfoComponent.prototype.playInBrowser = function (path) {
        var _this = this;
        this.fileSystemService.getShareLink(path)
            .then(function (shareLink) {
            var link = ['/player', btoa(shareLink.url), btoa(_this.fileInfo.fileInfo.mimetype)];
            _this.router.navigate(link);
        });
    };
    FileInfoComponent.prototype.directDownload = function () {
    };
    __decorate([
        core_1.Input(), 
        __metadata('design:type', file_info_1.FileInfo)
    ], FileInfoComponent.prototype, "fileInfo", void 0);
    __decorate([
        core_1.ViewChild('mavideo'), 
        __metadata('design:type', Object)
    ], FileInfoComponent.prototype, "mavideo", void 0);
    FileInfoComponent = __decorate([
        core_1.Component({
            selector: 'file-info',
            templateUrl: 'app/file-system/file-info/file-info.component.html',
        }), 
        __metadata('design:paramtypes', [router_1.Router, file_system_service_1.FileSystemService])
    ], FileInfoComponent);
    return FileInfoComponent;
}());
exports.FileInfoComponent = FileInfoComponent;
//# sourceMappingURL=file-info.component.js.map