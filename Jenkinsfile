pipeline {
    agent any

    environment {
        PATH = "$PATH:/user/local/bin"
    }

    stages {
        stage('Checkout') {
            steps {
                git url: 'https://github.com/MSPR-2-Bloc-4/API-Clients.git', branch: 'master'
            }
        }

        stage('Install dependencies') {
                    steps {
                        sh 'composer install'
                    }
                }

        stage('Run tests') {
            steps {
                sh 'php bin/phpunit --log-junit tests/report.xml'
            }
        }
    }
}