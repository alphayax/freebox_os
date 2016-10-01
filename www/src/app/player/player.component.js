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
var router_1 = require("@angular/router");
var PlayerComponent = (function () {
    function PlayerComponent(route) {
        this.route = route;
    }
    PlayerComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.route.params.forEach(function (params) {
            _this.url = atob(params['url']);
            _this.mimeType = atob(params['mime']);
        });
    };
    __decorate([
        core_1.ViewChild('mavideo'), 
        __metadata('design:type', Object)
    ], PlayerComponent.prototype, "mavideo", void 0);
    PlayerComponent = __decorate([
        core_1.Component({
            selector: 'player',
            templateUrl: 'app/player/player.component.html',
        }), 
        __metadata('design:paramtypes', [router_1.ActivatedRoute])
    ], PlayerComponent);
    return PlayerComponent;
}());
exports.PlayerComponent = PlayerComponent;
//# sourceMappingURL=player.component.js.map