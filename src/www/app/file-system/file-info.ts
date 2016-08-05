
export class FileInfoOriginal {
    filecount : any;
    foldercount: any;
    hidden: boolean;
    index : number;
    link: boolean;
    mimetype: string;
    modification : number;
    name : string;
    path : string;
    size: number;
    target : any;
    type: string;
}

export class FileInfo {
    fileInfo : FileInfoOriginal;

    name: string;
    path: string;
    image: string;
    isDir: boolean;
}
