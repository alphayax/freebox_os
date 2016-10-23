
export class DownloadTask {
    archive_password : string;
    created_ts : number;
    download_dir : string;
    error : string;
    eta : number;
    id : number;
    io_priority : string;
    name : string;
    queue_pos : number;
    rx_bytes : number;
    rx_pct : number;
    rx_rate : number;
    size : number;
    status : string;
    stop_ratio : number;
    tx_bytes : number;
    tx_pct : number;
    tx_rate : number;
    type : string;

}

export class MovieTitle {
    rawTitle: string;
    episode: number;
    season: number;
    cleanName: string;
}

export class DownloadItem {
    downloadTask : DownloadTask;
    movieTitle : MovieTitle;

    image : string;
    name : string;
    etaHr : string;
    path: string;
}

