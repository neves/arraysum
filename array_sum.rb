#!/usr/bin/env ruby

class ArraySum
  def initialize(input)
    @input = input.sort.reverse
    @count = 0
    @length = input.length
    @somas = []
    @output = [0] * @length
    soma = 0
    @input.reverse.each do |n|
      soma += n
      @somas.unshift(soma)
    end
  end

  def find(total, i = 0)
    @count += 1
    return false if i >= @length
    return false if total > @somas[i]
    current = @input[i]
    return !! @output[i] = total if total == current
    return true if find(total, i + 1)
    @output[i] = current
    return true if find(total - current, i + 1)
    @output[i] = 0

    return false
  end

  def result
    @output.select {|n| n > 0}
  end
end

module ArraySumExtension
  def array_sum(total)
    ar = ArraySum.new(self)
    ar.find(total)
    ar.result
  end
end

class Array
  include ArraySumExtension
end

require 'benchmark'

numeros = ARGV.map &:to_i
expected = numeros.shift

result = []
time = Benchmark.realtime { result = numeros.array_sum(expected) }
puts "%f" % time
puts result.join ' '
