node {
    def app

    stage('Clone repository'){
        checkout scm
    }

    stage('Build image'){
        /* build a docker image*/
        app = docker.build("vjadeja/test:${env.BUILD_NUMBER}")
    }

    stage('Test image'){
        /* run unit test inside new image*/
        docker.image("vjadeja/test:${env.BUILD_NUMBER}").inside() {
            sh 'php ./vendor/bin/phpunit'
        }
    }

    stage('Push image'){
        /* push a new docker image to docker hub registry using credentials*/
        docker.withRegistry('https://registry.hub.docker.com','docker-login'){
            app.push("${env.BUILD_NUMBER}")
            app.push("latest")
        }
        echo "Trying to push docker build to docker hub"
    }
}