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
var dl_rss_service_1 = require("./dl-rss.service");
var DlRssComponent = (function () {
    function DlRssComponent(dlRssService) {
        this.dlRssService = dlRssService;
    }
    DlRssComponent.prototype.checkRss = function (id) {
        var _this = this;
        this.dlRssService.checkRss(id)
            .then(function (result) { return _this.checkRssResults = result; });
    };
    DlRssComponent.prototype.cleanResults = function () {
        this.checkRssResults = [];
    };
    DlRssComponent.prototype.getPatterns = function () {
        var _this = this;
        this.dlRssService.getPatterns()
            .then(function (rssSearches) {
            _this.rssSearches = rssSearches;
        });
    };
    DlRssComponent.prototype.ngOnInit = function () {
        this.getPatterns();
    };
    DlRssComponent = __decorate([
        core_1.Component({
            selector: 'dl-rss',
            templateUrl: 'app/dl-rss/dl-rss.component.html',
            providers: [dl_rss_service_1.DlRssService]
        }), 
        __metadata('design:paramtypes', [dl_rss_service_1.DlRssService])
    ], DlRssComponent);
    return DlRssComponent;
}());
exports.DlRssComponent = DlRssComponent;
//# sourceMappingURL=dl-rss.component.js.map