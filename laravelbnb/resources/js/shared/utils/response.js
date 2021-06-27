export const is404 = function(err){
    return err.response && err.response.status && 404 === err.response.status;
};
export const is422 = function(err){
    return err.response && err.response.status && 422 === err.response.status;
};

export function isError(err, errStatus){
    if(err != null && errStatus != null){
        // Revisar que el status no sea nulo
        if(errStatus === parseInt(errStatus, 10)){
            return err.response && err.response.status && errStatus === err.response.status;
        }else{
            return null;
        }
    }else{
        return null;
    }
    
}


export function identifyError(err){
    if(err !== null){
        if(err.response && err.response.status) {
            const errStatus = err.response.status;
        switch (errStatus) {
            case 404:
                return errStatus+": You have already left a review";
                break;
            
            case 500:
                return errStatus+": Ah, sos re trol";
                break;

            case 422:
                return errStatus+": " + this.err.response.data.message + " " + this.err.response.data.errors.content; 
        
            default:
                return errStatus+": Undefined error";
                break;
        }
    }else{
        return "Unknown error";
    }
    }
    
}