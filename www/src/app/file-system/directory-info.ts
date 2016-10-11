
import {FileInfo} from "./file-info";

export class DirectoryPart {
    name: string;
    path: string;
}

export class DirectoryInfo {
    path: string;
    path_part: DirectoryPart;
    files : FileInfo[];
}

export class ShareLink {
    name : string;
    url : string;
    expire : string;
}
