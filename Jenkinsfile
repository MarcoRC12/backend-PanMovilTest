pipeline {
    agent any

    stages {
        
        stage('Preparacion'){
            steps {
                git branch:'main',url:'https://github.com/MarcoRC12/backend-PanMovilTest'
   	       		echo 'Pulled from github successfully'
            }
        }
        
        stage('Verifica version php'){
            steps {
                sh 'php --version'
            }
        }

        
       stage('Docker Build') {
            steps {
                sh 'docker build -t backend-panmovil .'
            }
        }

         stage('Deploy php') {
            steps {
                sh 'docker compose up -d'
            }
        }
    }
}
