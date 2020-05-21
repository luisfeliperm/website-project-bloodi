<?php
/**
 * @Luisfeliperm | Create 2019-10-08
 */
class SendPacket
{
    public $buffer;
    public $addr;
    public $port;

    public function int8($i) : void {
        $this->buffer .=  pack("c", $i);
    }
    public function uInt8($i) : void {
        $this->buffer .=  pack("C", $i);
    }
    public function int16($i) : void {
        $this->buffer .=  pack("s", $i);
    }
    public function uInt16($i) : void {
        $this->buffer .=  pack("v", $i);
    }
    public function int32($i) : void {
        $this->buffer .=  pack("l", $i);
    }
    public function uInt32($i) : void {
        $this->buffer .=  pack("V", $i);
    }
    public function int64($i) : void {
        $this->buffer .=  pack("q", $i);
    }
    public function uInt64($i) : void {
        $this->buffer .=  pack("P", $i);
    }

    public function Send() : void {
        if(strlen($this->buffer) < 1){
            echo "Envio cancelado devido ao pacote ser pequeno! [".strlen($this->buffer)."]";
            return;
        }
        
        $sk = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        socket_sendto($sk,  $this->buffer,strlen($this->buffer), 0, $this->addr, $this->port);
    }
    public function clear() : void{
        $this->buffer = null;
    }
}