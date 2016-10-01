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
var association_service_1 = require("./association.service");
var AssociationComponent = (function () {
    function AssociationComponent(associationService) {
        this.associationService = associationService;
    }
    AssociationComponent.prototype.addFreebox = function () {
        var _this = this;
        console.log("component : addFreebox");
        var association = {
            "app_token": this.app_token,
            "track_id": this.track_id,
            "api_domain": this.api_domain,
            "https_port": this.https_port
        };
        /// Check parameters
        if (!association.api_domain || !association.track_id || !association.https_port || !association.app_token) {
            console.error('Erreur : Tous les champs ne sont pas renseignes.');
            return;
        }
        this.associationService.addFreebox(association)
            .then(function (freebox) {
            console.log(freebox);
        })
            .catch(function (error) { return _this.error = error; });
    };
    AssociationComponent = __decorate([
        core_1.Component({
            selector: 'association',
            templateUrl: 'app/association/association.component.html',
            providers: [association_service_1.AssociationService]
        }), 
        __metadata('design:paramtypes', [association_service_1.AssociationService])
    ], AssociationComponent);
    return AssociationComponent;
}());
exports.AssociationComponent = AssociationComponent;
//# sourceMappingURL=association.component.js.map