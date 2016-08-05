import { Component, Input } from '@angular/core';
import { FileInfo } from "../file-info";

@Component({
    selector: 'file-info',
    templateUrl: 'app/file-system/file-info/file-info.component.html',
})

export class FileInfoComponent {

    @Input()
    fileInfo: FileInfo;
}

