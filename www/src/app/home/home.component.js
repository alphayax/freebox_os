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
var home_service_1 = require("./home.service");
var HomeComponent = (function () {
    function HomeComponent(homeService) {
        this.homeService = homeService;
    }
    HomeComponent.prototype.getFreeboxInfo = function () {
        var _this = this;
        this.homeService.getFreeboxInfo()
            .then(function (freeboxInfos) {
            _this.freeboxInfos = freeboxInfos;
            console.log(freeboxInfos);
        })
            .catch(function (error) { return _this.error = error; });
    };
    HomeComponent.prototype.ngOnInit = function () {
        this.getFreeboxInfo();
    };
    HomeComponent = __decorate([
        core_1.Component({
            selector: 'home',
            templateUrl: 'app/home/home.component.html',
            providers: [home_service_1.HomeService]
        }), 
        __metadata('design:paramtypes', [home_service_1.HomeService])
    ], HomeComponent);
    return HomeComponent;
}());
exports.HomeComponent = HomeComponent;
//# sourceMappingURL=home.component.js.map