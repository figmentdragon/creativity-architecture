const fs = require('fs');
const file = "assets/scripts/css/creataivityarchitect.min.css";
const data = fs.readFileSync(file);
const fd = fs.openSync(file, 'w+');
const buffer = new Buffer(
 `/*
 * The Creativity Architect - v1.0
 * https://thecreativityarchitect.com
 *
 * Copyright (C) 2022 "Creativity Architect" Carl Termini
 * licensed under the MIT license.
 * https://github.com/thecreativityarchitect/theme/blob/Main/LICENSE
 */`+"\n"
);

fs.writeSync(fd, buffer, 0, buffer.length, 0);
fs.writeSync(fd, data, 0, data.length, buffer.length);
fs.appendFileSync(file, "\n \n /*# sourceMappingURL=material.css.map */");
fs.close(fd);
