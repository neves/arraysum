#!/usr/bin/env python

class ArraySum:
  def __init__(self, input):
    self.input = sorted(input, reverse=True)
    self.count = 0
    self.length = len(self.input)
    self.somas = []
    self.output = [0 for i in self.input]
    input = sorted(input)
    soma = 0
    for i in range(0, self.length):
      soma += input[i]
      self.somas.append(soma)
    self.somas = self.somas[::-1]

  def find(self, total, i = 0):
    self.count += 1

    if i >= self.length: return False
    if total > self.somas[i]: return False

    current = self.input[i]

    if total == current:
     self.output[i] = total
     return True

    if self.find(total, i+1):
      return True

    self.output[i] = current

    if self.find(total-current, i+1):
      return True

    self.output[i] = 0

  def result(self):
    return [x for x in self.output if x > 0]

import sys, time

sys.setrecursionlimit(5000)

input = [int(x) for x in sys.argv[2::]]
expected = int(sys.argv[1])

arraySum = ArraySum(input)

before = time.clock()
arraySum.find(expected)
print "%f" % (time.clock() - before)
print ' '.join([str(x) for x in arraySum.result()])
