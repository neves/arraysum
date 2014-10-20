#!/usr/bin/env coffee

class ArraySum
  constructor: (input)->
    @input = input.sort (a, b)-> b-a
    @count = 0
    @length = input.length
    @somas = []
    @output = @input.map -> 0
    soma = 0

    for n in @input.slice(0).reverse()
      soma += n
      @somas.unshift(soma)

  find: (total, i = 0)->
    @count += 1
    return false if i >= @length
    return false if total > @somas[i]
    current = @input[i]
    return true if total == current && @output[i] = total
    return true if @find(total, i + 1)
    @output[i] = current
    return true if @find(total - current, i + 1)
    @output[i] = 0

    return false

  result: -> @output.filter (n)-> n > 0

lines = process.argv
lines.shift() # node
lines.shift() # script name

lines = lines.map (n)-> parseInt(n)
expected = lines.shift()

as = new ArraySum(lines)
before = Date.now()
as.find(expected)
after = Date.now()
console.log (after-before)/1000
console.log as.result().join " "
