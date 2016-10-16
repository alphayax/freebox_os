import { Pipe, PipeTransform } from '@angular/core';

@Pipe({name: 'o2hr'})
export class OctetToHumanReadablePipe implements PipeTransform {

    transform( octets: number): string {
        if(octets == 0) {
            return '0 octet';
        }
        var k = 1024; // or 1024 for binary
        var dm = 3;//decimals + 1 || 3;
        var sizes = ['octets', 'Ko', 'Mo', 'Go', 'To', 'Po', 'Eo', 'Zo', 'Yo'];
        var i = Math.floor(Math.log(octets) / Math.log(k));
        return parseFloat((octets / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }
}
