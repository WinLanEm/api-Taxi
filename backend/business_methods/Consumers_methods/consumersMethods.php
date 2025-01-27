<?php



require_once 'ConsumerRepository.php';

function getAllConsumers($connection)
{
    $consumersRepository = new ConsumerRepository($connection);
    $allConsumers = json_encode($consumersRepository->getAllConsumers());
    print_r($allConsumers);
}
function getConsumersById($connection,$id)
{
    $consumersRepository = new ConsumerRepository($connection);
    $consumer = $consumersRepository->getConsumerById($id);
    if($consumer){
        echo json_encode($consumer);
    }else{
        $res = [
            'status' => false,
            'message' => 'Consumer not found'
        ];
        http_response_code(404);
        echo(json_encode($res));
    }
}