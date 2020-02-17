node {
    def app

    stage('Clone repository'){
        checkout scm
    }

    stage('Build image'){
        app = docker.build("vjadeja/test:${env.BUILD_NUMBER}")
    }

    stage('Test image'){
        app.inside {
            sh 'vendor/bin/phpunit'
        }
    }

    stage('Push image'){
        docker.withRegistry('https://registry.hub.docker.com','docker-login'){
            app.push("${env.BUILD_NUMBER}")
        }
        echo "Trying to push docker build to docker hub"
    }
}