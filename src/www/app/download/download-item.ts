
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

export class DownloadItem {
    downloadTask : DownloadTask;

    image : string;
    name : string;
    sizeHr : string;
    rxTotalHr : string;
    txTotalHr : string;
    etaHr : string;
    cleanName : string;
    rxPct: number;
    txPct: number;
}

