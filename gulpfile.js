var gulp = require('gulp');
var plugins = require('gulp-load-plugins')();
var del = require('del');
var Q = require('q');

var config = {
    assetsDir: 'app/Resources/assets',
    sassPattern: 'sass/**/*.scss',
    bowerDir: 'vendor/bower_components',
    revManifestPath: 'app/Resources/assets/rev-manifest.json'
};
var app = {};

app.errorHandling = function(error) {
    console.log(error.toString());
    this.emit('end');
};

app.addStyle = function(paths, outputFilename) {
    return gulp.src(paths)
        .pipe(plugins.plumber(app.errorHandling(error)))
        .pipe(plugins.sourcemaps.init())
        .pipe(plugins.sass())
        .pipe(plugins.concat('css/'+outputFilename))
        .pipe(plugins.cleanCss())
        .pipe(plugins.rev())
        .pipe(plugins.sourcemaps.write('.'))
        .pipe(gulp.dest('web'))
        // write the rev-manifest.json file for gulp-rev
        .pipe(plugins.rev.manifest(config.revManifestPath, {
            merge: true
        }))
        .pipe(gulp.dest('.'));
};

app.addScript = function(paths, outputFilename) {
    return gulp.src(paths)
        .pipe(plugins.plumber(function(error) {
            console.log(error.toString());
            this.emit('end');
        }))
        .pipe(plugins.sourcemaps.init())
        .pipe(plugins.concat('js/'+outputFilename))
        .pipe(plugins.uglify())
        .pipe(plugins.rev())
        .pipe(plugins.sourcemaps.write('.'))
        .pipe(gulp.dest('web'))
        // write the rev-manifest.json file for gulp-rev
        .pipe(plugins.rev.manifest(config.revManifestPath, {
            merge: true
        }))
        .pipe(gulp.dest('.'));
};

app.copy = function(srcFiles, outputDir) {
    return gulp.src(srcFiles)
        .pipe(gulp.dest(outputDir));
};

var Pipeline = function() {
    this.entries = [];
};
Pipeline.prototype.add = function() {
    this.entries.push(arguments);
};

Pipeline.prototype.run = function(callable) {
    var deferred = Q.defer();
    var i = 0;
    var entries = this.entries;

    var runNextEntry = function() {
        // see if we're all done looping
        if (typeof entries[i] === 'undefined') {
            deferred.resolve();
            return;
        }

        // pass app as this, though we should avoid using "this"
        // in those functions anyways
        callable.apply(app, entries[i]).on('end', function() {
            i++;
            runNextEntry();
        });
    };
    runNextEntry();

    return deferred.promise;
};

gulp.task('styles', function() {
    var pipeline = new Pipeline();

    pipeline.add([
        config.bowerDir+'/bootstrap/dist/css/bootstrap.css',
        config.bowerDir+'/font-awesome/css/font-awesome.css',
        config.assetsDir+'/sass/base.scss'
    ], 'main.css');

    return pipeline.run(app.addStyle);
});

gulp.task('scripts', function() {
    var pipeline = new Pipeline();

    pipeline.add([
        config.bowerDir+'/jquery/dist/jquery.js',
        config.assetsDir+'/js/main.js'
    ], 'site.js');

    return pipeline.run(app.addScript);
});

gulp.task('fonts', function() {
    return app.copy(
        config.bowerDir+'/font-awesome/fonts/*',
        'web/fonts'
    );
});

gulp.task('clean', function() {
    del.sync(config.revManifestPath);
    del.sync('web/css/*');
    del.sync('web/js/*');
    del.sync('web/fonts/*');
});

gulp.task('watch', function() {
    gulp.watch(config.assetsDir+'/'+config.sassPattern, ['styles']);
    gulp.watch(config.assetsDir+'/js/**/*.js', ['scripts']);
});

gulp.task('default', ['clean', 'styles', 'scripts', 'fonts', 'watch']);