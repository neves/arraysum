fs = require 'fs'

process.stdin.on 'readable', ->
  buffer = process.stdin.read()
  if buffer
    console.log buffer.toString()
