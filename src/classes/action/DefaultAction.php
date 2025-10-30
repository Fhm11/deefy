<?php
declare(strict_types=1);
namespace iutnc\deefy\action;

class DefaultAction extends Action {

    public function execute() : string {
        return "<div> Bienvenue</div>" ;
    }

    public function __invoke():string{
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return $this->execute();
        } else {
           return "methode non autorisée";
        }
    }
}