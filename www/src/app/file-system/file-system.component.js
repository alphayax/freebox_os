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
var file_system_service_1 = require('./file-system.service');
var router_1 = require("@angular/router");
var FileSystemComponent = (function () {
    function FileSystemComponent(fileSystemService, route, router) {
        this.fileSystemService = fileSystemService;
        this.route = route;
        this.router = router;
    }
    FileSystemComponent.prototype.navigate = function (path) {
        this.router.navigate(['/file-system', btoa(path)]);
    };
    FileSystemComponent.prototype.getDirectoryInfo = function (path) {
        var _this = this;
        this.fileSystemService.getDirectoryInfo(path)
            .then(function (directoryInfo) {
            _this.directoryInfo = directoryInfo;
            _this.toto = directoryInfo.path_part;
            _this.files = directoryInfo.files;
            console.log(directoryInfo);
        })
            .catch(function (error) { return _this.error = error; });
    };
    FileSystemComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.route.params.forEach(function (params) {
            var path = params['path'];
            if (path) {
                path = atob(path);
            }
            else {
                path = '/';
            }
            _this.getDirectoryInfo(path);
        });
    };
    FileSystemComponent = __decorate([
        core_1.Component({
            selector: 'file-system',
            templateUrl: 'app/file-system/file-system.component.html',
            providers: [file_system_service_1.FileSystemService]
        }), 
        __metadata('design:paramtypes', [file_system_service_1.FileSystemService, router_1.ActivatedRoute, router_1.Router])
    ], FileSystemComponent);
    return FileSystemComponent;
}());
exports.FileSystemComponent = FileSystemComponent;
//# sourceMappingURL=file-system.component.js.map