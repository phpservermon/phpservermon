#! /usr/bin/env ruby -S rspec
require 'spec_helper'

describe "the dirname function" do
  let(:scope) { PuppetlabsSpec::PuppetInternals.scope }

  it "should exist" do
    expect(Puppet::Parser::Functions.function("dirname")).to eq("function_dirname")
  end

  it "should raise a ParseError if there is less than 1 arguments" do
    expect { scope.function_dirname([]) }.to( raise_error(Puppet::ParseError))
  end

  it "should return dirname for an absolute path" do
    result = scope.function_dirname(['/path/to/a/file.ext'])
    expect(result).to(eq('/path/to/a'))
  end

  it "should return dirname for a relative path" do
    result = scope.function_dirname(['path/to/a/file.ext'])
    expect(result).to(eq('path/to/a'))
  end
end
