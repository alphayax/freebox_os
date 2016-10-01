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
var AssociationService = (function () {
    function AssociationService(http) {
        this.http = http;
        // TODO : Mettre la vraie url externe
        this.config_freebox_url = 'http://ayx.freeboxos.fr:14789/freebox_os/api.php?service=config&action=association';
    }
    AssociationService.prototype.addFreebox = function (association) {
        var headers = new http_1.Headers();
        headers.append('Content-Type', 'application/json');
        return this.http.post(this.config_freebox_url, JSON.stringify(association), { headers: headers })
            .toPromise()
            .then(function (response) { return response.json().data; })
            .catch(this.handleError);
    };
    AssociationService.prototype.handleError = function (error) {
        console.error('HOME SERVICE : An error occurred', error);
        return Promise.reject(error.message || error);
    };
    AssociationService = __decorate([
        core_1.Injectable(), 
        __metadata('design:paramtypes', [http_1.Http])
    ], AssociationService);
    return AssociationService;
}());
exports.AssociationService = AssociationService;
//# sourceMappingURL=association.service.js.map